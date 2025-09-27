<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'name' => [
                'required',
                'max:250',
                'unique:categorys,name,' . ($this->category->id ?? ''),
            ],
            'description' => [
                'nullable',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && strlen(strip_tags($value)) < 10) {
                        $fail('La description doit contenir au moins 10 caractères.');
                    }
                }
            ],
            'short_description' => [
                'nullable',
                'max:500',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && strlen(strip_tags($value)) < 5) {
                        $fail('La description courte doit contenir au moins 5 caractères.');
                    }
                }
            ],
            'background_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $image = getimagesize($value);
                        if ($image[0] < 800 || $image[1] < 400) {
                            $fail("L'image d'arrière-plan doit avoir une résolution minimale de 800x400 pixels.");
                        }
                    }
                }
            ],
            'icon_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $image = getimagesize($value);
                        if ($image[0] < 100 || $image[1] < 100) {
                            $fail("L'icône doit avoir une résolution minimale de 100x100 pixels.");
                        }
                    }
                }
            ],
            'portrait_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $image = getimagesize($value);
                        if ($image[0] < 300 || $image[1] < 400) {
                            $fail("L'image portrait doit avoir une résolution minimale de 300x400 pixels.");
                        }
                    }
                }
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $request->flash();
        return response()->view('back.category.index', [
            'records' => Category::where('deleted', '0')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('back.category.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->except(['_token', '_method', 'background_image', 'icon_image', 'portrait_image']);

            if (empty($data['link'])) {
                $data['link'] = Str::slug($data['name']);
            }

            $category = Category::create($data);

            $imageFields = ['background_image', 'icon_image', 'portrait_image'];
            $updates = [];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    $timestamp = str_replace('.', '', microtime(true));
                    $extension = $request->file($field)->getClientOriginalExtension();
                    $fileName = "afrique-academy_{$category->link}_{$timestamp}.{$extension}";

                    $basePath = 'assets/images/categories';
                    if ($field === 'portrait_image') {
                        $basePath .= '/portrait';
                    }

                    $path = $request->file($field)->storeAs(
                        $basePath,
                        $fileName,
                        'public'
                    );

                    $updates[$field] = $path;
                }
            }

            if (!empty($updates)) {
                $category->update($updates);
            }

            DB::commit();
            return redirect()->route('category.index')->with('success', 'Catégorie créée avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création de la catégorie: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création de la catégorie: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category): Response
    {

        // Convertir les chemins d'images en URLs publiques via storage link
        if ($category->icon_image) {
            $category->icon_image = Storage::url($category->icon_image);
        }
        if ($category->background_image) {
            $category->background_image = Storage::url($category->background_image);
        }
        return response()->view('back.category.edit', ['record' => $category]);
    }

    public function update(Category $category, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->except(['_token', '_method', 'background_image', 'icon_image', 'portrait_image', 'link']);

            // Génère le nouveau lien uniquement si le nom a changé
            if ($category->name !== $data['name']) {
                $data['link'] = Str::slug($data['name']);

                // Vérifie si le nouveau slug existe déjà
                $counter = 1;
                $originalSlug = $data['link'];
                while (Category::where('link', $data['link'])
                    ->where('id', '!=', $category->id)
                    ->where('deleted', '0')
                    ->exists()) {
                    $data['link'] = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            $imageFields = ['background_image', 'icon_image', 'portrait_image'];
            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    if ($category->$field && Storage::disk('public')->exists($category->$field)) {
                        Storage::disk('public')->delete($category->$field);
                    }

                    $timestamp = time();
                    $extension = $request->file($field)->getClientOriginalExtension();
                    $fileName = "afrique-academy_{$category->link}_{$timestamp}.{$extension}";

                    $path = $request->file($field)->storeAs(
                        'assets/images/categories',
                        $fileName,
                        'public'
                    );

                    $data[$field] = $path;
                }
            }

            $category->update($data);

            DB::commit();
            return redirect()->route('category.index')->with('success', 'Catégorie mise à jour avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la mise à jour de la catégorie: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la catégorie: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->update([
            'deleted' => 1,
            'deleted_at' => now(),
            'deleted_by' => Auth::id()
        ]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }

    public function data()
    {
        return Category::getDataForDataTable();
    }
}

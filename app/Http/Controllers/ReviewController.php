<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $image = getimagesize($value);
                        if ($image[0] < 100 || $image[1] < 100) {
                            $fail("L'image de profil doit avoir une résolution minimale de 100x100 pixels.");
                        }
                    }
                }
            ],
            'company_url' => [
                'nullable',
                'url',
                'max:255'
            ],
            // ... autres règles
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
        return response()->view('back.review.index',
            [
                'records' => Review::all()->where('deleted', "0")
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $viewsData = [];

		$viewsData['coursesRecords'] = \App\Models\Course::all()->where('deleted','0');

        return response()->view('back.review.create', $viewsData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules(), [
                'picture.image' => 'Le fichier doit être une image.',
                'picture.mimes' => 'Le format de l\'image doit être : jpeg, png, jpg ou webp.',
                'picture.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $request->except(['_token', '_method', 'picture']);

            // Définir l'image par défaut en fonction du genre
            if (!$request->hasFile('picture')) {
                $data['picture'] = $request->input('genre') === 'Femme' ?
                    'assets/images/reviews/default-female.png' :
                    'assets/images/reviews/default-male.png';
            }

            $review = Review::create($data);

            if ($request->hasFile('picture')) {
                $timestamp = str_replace('.', '', microtime(true));
                $extension = $request->file('picture')->getClientOriginalExtension();
                $fileName = "review_{$timestamp}.{$extension}";

                $path = $request->file('picture')->storeAs(
                    'assets/images/reviews',
                    $fileName,
                    'public'
                );

                $review->update(['picture' => $path]);
            }

            DB::commit();
            return redirect()->route('review.index')->with('success', 'Review créée avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création de la review: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la création');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Review $review
     * @return Response
     */
    public function edit(Review $review): Response
    {
        // Convertir les chemins d'images en URLs publiques via storage link
        if ($review->picture) {
            $review->picture = Storage::url($review->picture);
        }

        $viewsData['record'] = $review;
        $viewsData['coursesRecords'] = \App\Models\Course::all()->where('deleted', '0');

        return response()->view('back.review.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Review $review
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Review $review, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules(), [
                'picture.image' => 'Le fichier doit être une image.',
                'picture.mimes' => 'Le format de l\'image doit être : jpeg, png, jpg, gif, svg ou webp.',
                'picture.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->except(['_token', '_method', 'picture', 'remove_picture']);

            // Gestion explicite du champ validation comme un switch
            if (isset($data['validation']) && $data['validation'] == "on") {
                $data['validation'] = true;
            } else {
                $data['validation'] = false;
            }

            // Log pour déboguer
            \Log::info('Données de mise à jour:', [
                'validation_input' => $request->input('validation'),
                'validation_final' => $data['validation'],
                'all_data' => $data
            ]);

            // Gestion de la suppression d'image
            if ($request->has('remove_picture')) {
                if ($review->picture && Storage::disk('public')->exists($review->picture)) {
                    Storage::disk('public')->delete($review->picture);
                }
                $data['picture'] = null;
            }

            // Gestion de la nouvelle image
            if ($request->hasFile('picture')) {
                if ($review->picture && Storage::disk('public')->exists($review->picture)) {
                    Storage::disk('public')->delete($review->picture);
                }

                $timestamp = str_replace('.', '', microtime(true));
                $extension = $request->file('picture')->getClientOriginalExtension();
                $slugName = Str::slug($review->name);
                $fileName = "review_{$slugName}_{$timestamp}.{$extension}";

                $path = $request->file('picture')->storeAs(
                    'assets/images/reviews',
                    $fileName,
                    'public'
                );

                $data['picture'] = $path;
            }

            $review->update($data);

            DB::commit();
            return redirect()->route('review.index')->with('success', 'Review mise à jour avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la mise à jour de la review: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @return JsonResponse
     */
    public function destroy(Review $review): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Supprimer l'image si elle existe
            if ($review->picture && Storage::disk('public')->exists($review->picture)) {
                Storage::disk('public')->delete($review->picture);
            }

            $review->update([
                'deleted' => 1,
                'deleted_at' => now(),
                'deleted_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "L'enregistrement a été supprimé avec succès"
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la suppression de la review: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue lors de la suppression"
            ], 500);
        }
    }


    public function data()
            {
               return review::getDataForDataTable();
            }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|max:250',
            'link' => [
                'required',
                'max:250',
                Rule::unique('courses')->ignore(request()->route('course')),
            ],
            'category_id' => 'required|exists:categorys,id',
            'duration' => 'nullable|numeric|min:0',
            'duration_unit' => 'nullable|in:heures,jours,semaines,mois',
            'is_certified' => 'boolean',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sidebar_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'modules' => 'nullable|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.content' => 'required|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string|max:255',
            'faqs.*.answer' => 'required_with:faqs|string'
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
        return response()->view('back.course.index',
            [
                'records' => Course::all()->where('deleted', "0")
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

		$viewsData['categoryRecords'] = \App\Models\Category::all()->where('deleted','0');

        return response()->view('back.course.create', $viewsData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Ajouter le lien basé sur le nom avant la validation
            $data = $request->all();
            $data['link'] = Str::slug($data['name']);

            // Log des données reçues
            \Log::info('Données reçues pour la création du cours:', [
                'all_data' => $data,
                'modules' => $data['modules'] ?? 'Aucun module',
                'faqs' => $data['faqs'] ?? 'Aucune FAQ'
            ]);

            // Valider la requête avec les nouvelles règles
            $validator = Validator::make($data, array_merge($this->getRules(), [
                'faqs' => 'nullable|array',
                'faqs.*.question' => 'required|string|max:255',
                'faqs.*.answer' => 'required|string'
            ]));

            if ($validator->fails()) {
                \Log::error('Erreur de validation:', $validator->errors()->toArray());

                // Convertir les FAQs en tableau si nécessaire
                $faqs = $data['faqs'] ?? [];
                if (is_string($faqs)) {
                    try {
                        $faqs = json_decode($faqs, true);
                        if (!is_array($faqs)) {
                            $faqs = [];
                        }
                    } catch (\JsonException $e) {
                        $faqs = [];
                        \Log::error('Erreur de décodage des FAQs:', ['error' => $e->getMessage()]);
                    }
                }

                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('oldModules', $data['modules'] ?? [])
                    ->with('oldFaqs', $faqs);
            }

            // Filtrer les données pour la création
            $courseData = collect($data)->except([
                '_token',
                '_method',
                'icon_image',
                'sidebar_image',
                'description_image',
                'modules',
                'faqs'
            ])->toArray();

            // Créer le cours
            $course = Course::create($courseData);
            \Log::info('Cours créé avec succès:', ['course_id' => $course->id]);

            // Traitement des images
            $imageFields = ['icon_image', 'sidebar_image', 'description_image'];
            $updates = [];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    $timestamp = str_replace('.', '', microtime(true));
                    $extension = $request->file($field)->getClientOriginalExtension();
                    $fileName = "afrique-academy_{$course->link}_{$timestamp}.{$extension}";

                    $path = $request->file($field)->storeAs(
                        'assets/images/formations',
                        $fileName,
                        'public'
                    );

                    $updates[$field] = $path;
                }
            }

            // Mettre à jour le cours avec les chemins des images si nécessaire
            if (!empty($updates)) {
                $course->update($updates);
            }

            // Traitement des modules
            if (isset($data['modules']) && is_array($data['modules'])) {
                \Log::info('Traitement des modules:', ['modules' => $data['modules']]);

                foreach ($data['modules'] as $index => $moduleData) {
                    \Log::info('Traitement du module:', [
                        'index' => $index,
                        'data' => $moduleData
                    ]);

                    try {
                        $course->modules()->create([
                            'title' => trim($moduleData['title']),
                            'content' => trim($moduleData['content']),
                            'order' => $index + 1
                        ]);
                        \Log::info('Module créé avec succès');
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors de la création du module:', [
                            'error' => $e->getMessage(),
                            'module_data' => $moduleData
                        ]);
                        throw $e;
                    }
                }
            } else {
                \Log::info('Aucun module à traiter');
            }

            // Traitement des FAQs
            if (isset($data['faqs']) && is_array($data['faqs'])) {
                \Log::info('Traitement des FAQs:', ['faqs' => $data['faqs']]);

                foreach ($data['faqs'] as $index => $faqData) {
                    try {
                        // Vérifier que les données FAQ sont valides
                        if (!isset($faqData['question']) || !isset($faqData['answer'])) {
                            throw new \Exception('Données FAQ incomplètes');
                        }

                        $course->faqs()->create([
                            'question' => trim($faqData['question']),
                            'answer' => trim($faqData['answer']),
                            'order' => $index + 1
                        ]);
                        \Log::info('FAQ créée avec succès');
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors de la création de la FAQ:', [
                            'error' => $e->getMessage(),
                            'faq_data' => $faqData
                        ]);
                        throw $e;
                    }
                }
            } else {
                \Log::info('Aucune FAQ à traiter');
            }

            DB::commit();
            return redirect()->route('course.index')->with('success', 'Formation créée avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création de la formation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Même traitement pour le rollback
            $faqs = $data['faqs'] ?? [];
            if (is_string($faqs)) {
                try {
                    $faqs = json_decode($faqs, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $faqs = [];
                    \Log::error('Erreur de décodage des FAQs:', ['error' => $e->getMessage()]);
                }
            }

            return back()
                ->with('error', 'Une erreur est survenue lors de la création de la formation: ' . $e->getMessage())
                ->withInput()
                ->with('oldModules', $data['modules'] ?? [])
                ->with('oldFaqs', $faqs);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return Response
     */
    public function edit(Course $course): Response
    {
        // Convertir les chemins d'images en URLs publiques via storage link
        if ($course->icon_image) {
            $course->icon_image = Storage::url($course->icon_image);
        }
        if ($course->sidebar_image) {
            $course->sidebar_image = Storage::url($course->sidebar_image);
        }
        if ($course->description_image) {
            $course->description_image = Storage::url($course->description_image);
        }
        $viewsData['record'] = $course;
        $viewsData['nextCourse'] = $course->next();
        $viewsData['previousCourse'] = $course->previous();
        $viewsData['categoryRecords'] = \App\Models\Category::all()->where('deleted','0');

        return response()->view('back.course.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Course $course
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Course $course, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Désactiver temporairement l'indexation Algolia si nécessaire
            $course->withoutSyncingToSearch(function () use ($course, $request) {
                // Retirer 'faqs' des données à mettre à jour dans la table courses
                $data = $request->except([
                    '_token',
                    '_method',
                    'icon_image',
                    'sidebar_image',
                    'description_image',
                    'modules',
                    'program',
                    'faqs'
                ]);

                // Valider la requête
                $validator = Validator::make($request->all(), $this->getRules());
                if ($validator->fails()) {
                    throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
                }

                // Traitement des images
                $imageFields = ['icon_image', 'sidebar_image', 'description_image'];
                foreach ($imageFields as $field) {
                    if ($request->hasFile($field)) {
                        // Supprimer l'ancienne image si elle existe
                        if ($course->$field && Storage::disk('public')->exists($course->$field)) {
                            Storage::disk('public')->delete($course->$field);
                        }

                        // Générer un nom unique pour l'image
                        $timestamp = time();
                        $extension = $request->file($field)->getClientOriginalExtension();
                        $fileName = "afrique-academy_{$course->link}_{$timestamp}.{$extension}";

                        // Upload de la nouvelle image avec le nom personnalisé
                        $path = $request->file($field)->storeAs(
                            'assets/images/formations',
                            $fileName,
                            'public'
                        );

                        $data[$field] = $path;
                    }
                }

                // Mise à jour des informations du cours
                $course->update($data);
            });

            // Mise à jour des modules
            if ($request->has('modules')) {
                try {
                    // Supprimer tous les anciens modules
                    $course->modules()->delete();

                    // Créer les nouveaux modules
                    foreach ($request->modules as $index => $moduleData) {
                        $course->modules()->create([
                            'title' => trim($moduleData['title']),
                            'content' => trim($moduleData['content']),
                            'order' => $index + 1
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la mise à jour des modules:', [
                        'error' => $e->getMessage(),
                        'modules' => $request->modules
                    ]);
                    throw $e;
                }
            }

            // Mise à jour des FAQs
            if ($request->has('faqs')) {
                try {
                    // Supprimer toutes les anciennes FAQs
                    $course->faqs()->delete();

                    // Créer les nouvelles FAQs
                    foreach ($request->faqs as $index => $faqData) {
                        $course->faqs()->create([
                            'question' => trim($faqData['question']),
                            'answer' => trim($faqData['answer']),
                            'order' => $index + 1
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la mise à jour des FAQs:', [
                        'error' => $e->getMessage(),
                        'faqs' => $request->faqs
                    ]);
                    throw $e;
                }
            }

            // Forcer la réindexation après toutes les mises à jour
            $course->searchable();

            DB::commit();
            return redirect()
                ->route('course.edit', ['course' => $course->id])
                ->with('success', 'Formation mise à jour avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la mise à jour de la formation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la formation: ' . $e->getMessage())
                ->withInput()
                ->with('oldModules', $request->modules ?? [])
                ->with('oldFaqs', $request->faqs ?? []);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        $course->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function data()
            {
               return course::getDataForDataTable();
            }

}

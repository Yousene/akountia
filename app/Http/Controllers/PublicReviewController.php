<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Contrôleur pour gérer les avis publics
 */
class PublicReviewController extends Controller
{
    /**
     * Affiche le formulaire de création d'un avis public
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $coursesRecords = Course::where('deleted', 0)->orderBy('name')->get();
            return view('front.review.create', [
                'coursesRecords' => $coursesRecords,
                'layout' => 'layouts.front'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du formulaire d\'avis public: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Une erreur est survenue lors du chargement du formulaire.');
        }
    }

    /**
     * Enregistre un nouvel avis public
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'genre' => 'required|in:Homme,Femme',
                'company' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'course_id' => 'required|exists:courses,id',
                'rating' => 'required|numeric|min:0.5|max:5',
                'comment' => 'required|string',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);

            \DB::beginTransaction();

            $review = new Review();
            $review->fill($validated);
            $review->validation = false;

            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $request->file('picture')->storeAs(
                    'assets/images/reviews',
                    $filename,
                    'public'
                );
                $review->picture = $path;
            } else {
                // Utiliser le même chemin que dans le modèle Review
                $review->picture = 'assets/images/reviews/' . ($request->genre === 'Femme' ? 'default-female.webp' : 'default-male.webp');
            }

            $review->save();

            \DB::commit();

            Log::info('Nouvel avis public créé par ' . $request->name);
            return redirect()->back()->with('success', 'Merci ! Votre avis a été enregistré et sera publié après validation.');

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Erreur lors de l\'enregistrement de l\'avis public: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre avis.');
        }
    }
}

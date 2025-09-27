<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Récupère les données pour la recherche globale
     *
     * @return JsonResponse
     */
    public function getSearchData(): JsonResponse
    {
        try {
            // Récupération des formations
            $courses = Course::where('deleted', '0')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($course) {
                    return [
                        'id' => $course->id,
                        'name' => $course->name,
                        'subtitle' => $course->link ?? '',
                        'icon' => 'bx-book-open',
                        'useIcon' => empty($course->icon_image),
                        'src' => $course->icon_image ? asset('uploads/courses/' . $course->icon_image) : null,
                        'url' => route('course.edit', $course->id)
                    ];
                });

            // Récupération des catégories
            $categories = Category::where('deleted', '0')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'subtitle' => $category->link ?? '',
                        'icon' => 'bx-category',
                        'useIcon' => empty($category->icon_image),
                        'src' => $category->icon_image ? asset('uploads/categories/' . $category->icon_image) : null,
                        'url' => route('category.edit', $category->id)
                    ];
                });

            // Ne renvoyer que les sections non vides
            $response = [];
            if ($courses->isNotEmpty()) {
                $response['courses'] = $courses->toArray();
            }
            if ($categories->isNotEmpty()) {
                $response['categories'] = $categories->toArray();
            }

            return response()->json($response);

        } catch (\Exception $e) {
            \Log::error('Erreur de recherche: ' . $e->getMessage());
            return response()->json([]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\CourseSearchCollection;
use App\Traits\ApiResponseTrait;
class SearchApiController extends Controller
{
    use ApiResponseTrait;

    /**
     * Recherche des cours via Algolia
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCourses(Request $request): JsonResponse
    {
        try {
            // Si aucun terme de recherche n'est fourni, retourner un résultat vide
            if (!$request->filled('query')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'courses' => [],
                        'meta' => [
                            'total' => 0,
                            'query' => null,
                            'filters' => [],
                            'per_page' => (int) $request->query('per_page', 9),
                            'current_page' => 1
                        ]
                    ]
                ]);
            }

            // Préparation des paramètres de pagination
            $perPage = (int) $request->query('per_page', 9);
            $page = (int) $request->query('page', 1);

            // Préparation des filtres
            $filters = [];
            if ($request->has('category_id')) {
                $filters[] = "category_id:{$request->category_id}";
            }
            if ($request->has('is_certified')) {
                $filters[] = "is_certified:{$request->is_certified}";
            }

            // Effectuer la recherche avec pagination
            $searchResults = Course::search($request->query('query'))
                ->when(!empty($filters), function ($query) use ($filters) {
                    return $query->with(['filters' => implode(' AND ', $filters)]);
                })
                ->paginate($perPage, 'courses', $page);

            // Retourner les résultats formatés
            return response()->json(new CourseSearchCollection($searchResults));

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recherche Algolia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la recherche',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

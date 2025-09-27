<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseDetailResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

class CourseApiController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var int Nombre d'éléments par page par défaut
     */
    private const DEFAULT_PER_PAGE = 10;

    public function __construct()
    {
        // Commenté ou supprimé pour désactiver l'authentification
        // $this->middleware('auth:sanctum');
    }

    /**
     * Récupère la liste de tous les cours actifs avec pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', self::DEFAULT_PER_PAGE);

            $courses = Course::query()
                ->with([
                    'categoryDetail' => function ($query) {
                        $query->where('deleted', '0');
                    }
                ])
                ->where('deleted', '0')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return $this->sendPaginatedResponse($courses, CourseResource::class);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des cours', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->handleError($e, 'de la récupération des cours');
        }
    }

    /**
     * Récupère les détails d'un cours spécifique
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $course = Course::with(['categoryDetail', 'modules', 'faqs'])
                ->where('deleted', '0')
                ->findOrFail($id);

            return response()->json(new CourseDetailResource($course));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Formation', $id);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération du cours');
        }
    }

    /**
     * Recherche des cours par critères
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = Course::query()
                ->with([
                    'categoryDetail' => function ($query) {
                        $query->where('deleted', '0');
                    }
                ])
                ->where('deleted', '0');

            // Appliquer les filtres
            $this->applySearchFilters($query, $request);

            $perPage = $request->input('per_page', self::DEFAULT_PER_PAGE);
            $courses = $query->paginate($perPage);

            return $this->sendPaginatedResponse($courses, CourseResource::class);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche des cours', [
                'filters' => $request->all(),
                'error' => $e->getMessage()
            ]);

            return $this->handleError($e, 'de la recherche des cours');
        }
    }

    /**
     * Applique les filtres de recherche à la requête
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return void
     */
    private function applySearchFilters($query, Request $request): void
    {
        $filters = [
            'category_id' => 'category_id',
            'is_certified' => 'is_certified',
            'duration_unit' => 'duration_unit',
            'title' => ['title', 'like', '%{value}%'],
            'price_min' => ['price', '>='],
            'price_max' => ['price', '<='],
        ];

        foreach ($filters as $param => $filter) {
            if ($request->has($param)) {
                if (is_array($filter)) {
                    $value = $request->input($param);
                    if ($filter[1] === 'like') {
                        $value = str_replace('{value}', $value, $filter[2]);
                    }
                    $query->where($filter[0], $filter[1], $value);
                } else {
                    $query->where($filter, $request->input($param));
                }
            }
        }
    }

    /**
     * Envoie une réponse paginée standardisée
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @param string $resourceClass
     * @return JsonResponse
     */
    private function sendPaginatedResponse($paginator, string $resourceClass): JsonResponse
    {
        if ($paginator->isEmpty()) {
            return response()->json([
                'items' => [],
                'meta' => [
                    'current_page' => 1,
                    'per_page' => self::DEFAULT_PER_PAGE,
                    'total' => 0,
                    'message' => 'Aucun cours trouvé'
                ]
            ], 200);
        }

        // Créer la collection de ressources
        $collection = $resourceClass::collection($paginator);

        // Retourner directement la collection transformée
        return response()->json($collection);
    }

    /**
     * Récupère un cours par son lien
     *
     * @param string $link
     * @return JsonResponse
     */
    public function showByLink(string $link): JsonResponse
    {
        try {
            $course = Course::with(['categoryDetail', 'modules', 'faqs'])
                ->where('deleted', '0')
                ->where('link', $link)
                ->firstOrFail();

            return response()->json(new CourseDetailResource($course));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Formation', $link);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération du cours par lien');
        }
    }

    /**
     * Récupère les cours par le lien de la catégorie
     *
     * @param Request $request
     * @param string $categoryLink
     * @return JsonResponse
     */
    public function getByCategoryLink(Request $request, string $categoryLink): JsonResponse
    {
        try {
            $showAll = $request->query('show_all', false);

            $query = Course::with(['categoryDetail'])
                ->whereHas('categoryDetail', function ($query) use ($categoryLink) {
                    $query->where('link', $categoryLink)
                        ->where('deleted', '0');
                })
                ->where('deleted', '0');

            // Calculer les statistiques des reviews pour tous les cours de la catégorie
            $categoryStats = DB::table('reviews')
                ->join('courses', 'reviews.course_id', '=', 'courses.id')
                ->join('categorys', 'courses.category_id', '=', 'categorys.id')
                ->where('categorys.link', $categoryLink)
                ->where('categorys.deleted', '0')
                ->where('courses.deleted', '0')
                ->where('reviews.deleted', '0')
                ->where('reviews.validation', '1')
                ->select(
                    DB::raw('ROUND(AVG(reviews.rating), 1) as average_rating'),
                    DB::raw('MAX(reviews.rating) as max_rating'),
                    DB::raw('MIN(reviews.rating) as min_rating'),
                    DB::raw('COUNT(*) as total_reviews')
                )
                ->first();

            if ($showAll === 'true') {
                $courses = $query->paginate(100);
            } else {
                $courses = $query->paginate(9);
            }

            if ($courses->isEmpty()) {
                return response()->json([
                    'items' => [],
                    'meta' => [
                        'total' => 0,
                        'message' => 'Aucun cours trouvé dans cette catégorie'
                    ]
                ], 200);
            }

            $response = CourseResource::collection($courses);
            $response['category_reviews'] = [
                'average' => $categoryStats->average_rating ?? 0,
                'best_rating' => $categoryStats->max_rating ?? 0,
                'worst_rating' => $categoryStats->min_rating ?? 0,
                'count' => $categoryStats->total_reviews ?? 0
            ];
            // $response['category'] = $courses->first()->categoryDetail;

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des cours par catégorie: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Une erreur est survenue lors de la récupération des cours'
            ], 500);
        }
    }

}

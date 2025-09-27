<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CategoryResource;
use App\Traits\ApiResponseTrait;

class CategoryApiController extends Controller
{
    use ApiResponseTrait;

    /**
     * Constructeur avec middleware d'authentification
     */
    public function __construct()
    {
        // Supprimer le middleware d'authentification
    }

    /**
     * Récupère la liste de toutes les catégories actives
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 20); // 10 est la valeur par défaut
            $categories = Category::where('deleted', '0')
                ->select('id', 'name', 'link', 'short_description', 'description', 'background_image', 'icon_image', 'portrait_image', 'created_at', 'updated_at')
                ->paginate($perPage);

            if ($categories->isEmpty()) {
                return response()->json([
                    'items' => [],
                    'meta' => [
                        'total' => 0,
                        'message' => 'Aucune catégorie trouvée'
                    ]
                ], 200);
            }

            return response()->json(CategoryResource::collection($categories));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des catégories: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Une erreur est survenue lors de la récupération des catégories'
            ], 500);
        }
    }

    /**
     * Récupère les détails d'une catégorie spécifique par ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $category = Category::where('deleted', '0')->findOrFail($id);
            return response()->json(new CategoryResource($category));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Catégorie', $id);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération de la catégorie');
        }
    }

    /**
     * Récupère une catégorie par son lien
     *
     * @param string $link
     * @return JsonResponse
     */
    public function showByLink(string $link): JsonResponse
    {
        try {
            $category = Category::where('deleted', '0')
                ->where('link', $link)
                ->firstOrFail();

            return response()->json(new CategoryResource($category));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Catégorie', $link);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération de la catégorie par lien');
        }
    }

    /**
     * Recherche des catégories par nom
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = Category::where('deleted', '0');

            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            $categories = $query->get();

            if ($categories->isEmpty()) {
                return $this->handleEmptyResponse('catégorie');
            }

            return response()->json([
                'success' => true,
                'data' => CategoryResource::collection($categories)
            ]);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la recherche des catégories');
        }
    }

    /**
     * Récupère tous les cours d'une catégorie
     *
     * @param int $category
     * @return JsonResponse
     */
    public function showCoursesByCategory(int $category): JsonResponse
    {
        try {
            $courses = Course::with(['categoryDetail'])
                ->where('deleted', '0')
                ->where('category_id', $category)
                ->paginate(10);

            if ($courses->isEmpty()) {
                return response()->json([
                    'items' => [],
                    'meta' => [
                        'total' => 0,
                        'message' => 'Aucun cours trouvé dans cette catégorie'
                    ]
                ], 200);
            }

            return response()->json(CourseResource::collection($courses));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des cours par catégorie: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Une erreur est survenue lors de la récupération des cours'
            ], 500);
        }
    }
}

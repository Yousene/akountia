<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponseTrait
{
    /**
     * Gère la réponse en cas de ressource non trouvée
     *
     * @param ModelNotFoundException $e
     * @param string $resourceName
     * @param string|int $identifier
     * @return JsonResponse
     */
    protected function handleNotFound(ModelNotFoundException $e, string $resourceName, $identifier): JsonResponse
    {
        Log::error("{$resourceName} non trouvé(e) avec l'identifiant: " . $identifier);
        return response()->json([
            'success' => false,
            'message' => "{$resourceName} non trouvé(e)",
            'error' => 'Not Found'
        ], 404);
    }

    /**
     * Gère la réponse en cas d'erreur générale
     *
     * @param \Exception $e
     * @param string $context
     * @return JsonResponse
     */
    protected function handleError(\Exception $e, string $context): JsonResponse
    {
        Log::error("Erreur lors de {$context}: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => "Une erreur est survenue lors de {$context}",
            'error' => 'Internal Server Error'
        ], 500);
    }

    /**
     * Gère la réponse pour une liste vide
     *
     * @param string $resourceName
     * @return JsonResponse
     */
    protected function handleEmptyResponse(string $resourceName): JsonResponse
    {
        return response()->json([
            'items' => [],
            'meta' => [
                'total' => 0,
                'message' => "Aucun(e) {$resourceName} trouvé(e)"
            ]
        ], 200);
    }

    /**
     * Gère la réponse en cas de lien non trouvé
     *
     * @param ModelNotFoundException $e
     * @param string $resourceName
     * @param string $link
     * @return JsonResponse
     */
    protected function handleLinkNotFound(ModelNotFoundException $e, string $resourceName, string $link): JsonResponse
    {
        Log::error("{$resourceName} non trouvé(e) avec le lien: " . $link);
        return response()->json([
            'success' => false,
            'message' => "Aucun(e) {$resourceName} trouvé(e) avec le lien spécifié",
            'error' => 'Not Found'
        ], 404);
    }
}

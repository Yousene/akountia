<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ClientResource;
use App\Traits\ApiResponseTrait;


class ClientApiController extends Controller
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
     * Récupère la liste de tous les clients actifs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);
            $query = Client::where('deleted', '0');

            // Filtre pour les clients prioritaires
            if ($request->has('is_priority')) {
                $isPriority = filter_var($request->input('is_priority'), FILTER_VALIDATE_BOOLEAN);
                $query->where('is_priority', $isPriority);
            }

            $clients = $query->paginate($perPage);

            if ($clients->isEmpty()) {
                return response()->json([
                    'items' => [],
                    'meta' => [
                        'total' => 0,
                        'message' => 'Aucun client trouvé'
                    ]
                ], 200);
            }

            return response()->json(ClientResource::collection($clients));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des clients: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Une erreur est survenue lors de la récupération des clients'
            ], 500);
        }
    }

    /**
     * Récupère les détails d'un client spécifique par ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $client = Client::where('deleted', '0')->findOrFail($id);
            return response()->json(new ClientResource($client));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Client', $id);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération du client');
        }
    }

    /**
     * Récupère un client par son lien
     *
     * @param string $link
     * @return JsonResponse
     */
    public function showByLink(string $link): JsonResponse
    {
        try {
            $client = Client::where('deleted', '0')
                ->where('link', $link)
                ->firstOrFail();

            return response()->json(new ClientResource($client));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFound($e, 'Client', $link);
        } catch (\Exception $e) {
            return $this->handleError($e, 'de la récupération du client par lien');
        }
    }

    /**
     * Recherche des clients par nom et statut prioritaire
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = Client::where('deleted', '0');

            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            // Ajout du filtre pour les clients prioritaires
            if ($request->has('is_priority')) {
                $isPriority = filter_var($request->input('is_priority'), FILTER_VALIDATE_BOOLEAN);
                $query->where('is_priority', $isPriority);
            }

            $clients = $query->get();

            if ($clients->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aucun client ne correspond aux critères de recherche',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => ClientResource::collection($clients)
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche des clients: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la recherche des clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

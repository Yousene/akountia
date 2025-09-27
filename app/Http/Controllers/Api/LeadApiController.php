<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LeadApiController extends Controller
{
    /**
     * Crée un nouveau lead
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Validation des données
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|in:Particulier,Entreprise',
                'name' => 'required|string|max:255',
                'company' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'city' => 'required|string|in:Casablanca,Rabat,Reste du monde',
                'course' => 'required|string|max:300',
                'category' => 'required|string|max:300',
                'phone' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Préparation des données avec le statut par défaut
            $data = $request->all();
            $data['statut'] = 1; // Statut "Non définie"
            $data['created_by'] = 1; // Valeur par défaut pour created_by
            $data['created_at'] = now()->format('Y-m-d H:i:s'); // Valeur par défaut pour created_at
            $data['updated_at'] = now()->format('Y-m-d H:i:s'); // Valeur par défaut pour updated_at

            // Création du lead
            $lead = Lead::create($data);

            DB::commit();

            Log::info('Lead créé avec succès via API', [
                'lead_id' => $lead->id,
                'email' => $lead->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead créé avec succès',
                'data' => $lead
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du lead via API', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du lead',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

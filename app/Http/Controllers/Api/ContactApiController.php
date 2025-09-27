<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactApiController extends Controller
{
    /**
     * Crée un nouveau contact
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string'
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

            // Création du contact
            $contact = Contact::create($data);

            DB::commit();

            \Log::info('Contact créé avec succès via API', [
                'contact_id' => $contact->id,
                'email' => $contact->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contact créé avec succès',
                'data' => $contact
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la création du contact via API', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'name' => [
                'required',
                'max:250',
            ],
            'icon_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Vérifier si c'est un SVG
                        if (strtolower($value->getClientOriginalExtension()) === 'svg') {
                            // Pour les SVG, on ne vérifie pas la taille
                            return;
                        }

                        // Pour les autres types d'images
                        $image = @getimagesize($value);
                        if ($image === false) {
                            $fail("Le fichier n'est pas une image valide.");
                            return;
                        }

                        if ($image[0] < 100 || $image[1] < 100) {
                            $fail("L'icône doit avoir une résolution minimale de 100x100 pixels.");
                        }
                    }
                }
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Vérifier si c'est un SVG
                        if (strtolower($value->getClientOriginalExtension()) === 'svg') {
                            // Pour les SVG, on ne vérifie pas la taille
                            return;
                        }

                        // Pour les autres types d'images
                        $image = @getimagesize($value);
                        if ($image === false) {
                            $fail("Le fichier n'est pas une image valide.");
                            return;
                        }

                        if ($image[0] < 800 || $image[1] < 400) {
                            $fail("L'image doit avoir une résolution minimale de 800x400 pixels.");
                        }
                    }
                }
            ]
        ];
    }

    public function index(Request $request): Response
    {
        $request->flash();
        return response()->view('back.client.index', [
            'records' => Client::where('deleted', '0')->get()
        ]);
    }

    public function create(): Response
    {
        return response()->view('back.client.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->except(['_token', '_method', 'image', 'icon_image']);

            if (empty($data['link'])) {
                $data['link'] = Str::slug($data['name']);
            }

            $client = Client::create($data);

            $imageFields = ['image', 'icon_image'];
            $updates = [];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    $timestamp = str_replace('.', '', microtime(true));
                    $extension = $request->file($field)->getClientOriginalExtension();
                    $fileName = "client_{$client->link}_{$timestamp}.{$extension}";

                    $path = $request->file($field)->storeAs(
                        $field === 'icon_image' ? 'assets/images/clients/icons' : 'assets/images/clients',
                        $fileName,
                        'public'
                    );

                    $updates[$field] = $path;
                }
            }

            if (!empty($updates)) {
                $client->update($updates);
            }

            DB::commit();
            return redirect()->route('client.index')->with('success', 'Client créé avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création du client: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création du client: ' . $e->getMessage());
        }
    }

    public function edit(Client $client): Response
    {
        // Convertir les chemins d'images en URLs publiques via storage link
        if ($client->icon_image) {
            $client->icon_image = Storage::url($client->icon_image);
        }
        if ($client->image) {
            $client->image = Storage::url($client->image);
        }
        return response()->view('back.client.edit', ['record' => $client]);
    }

    public function update(Client $client, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->except(['_token', '_method', 'image', 'icon_image']);

            // Vérification du statut prioritaire
            if (isset($data['is_priority']) && $data['is_priority'] == "on") {
                $nbPrioritaires = Client::where('is_priority', true)
                    ->where('deleted', 0)
                    ->where('id', '!=', $client->id)
                    ->count();

                if ($nbPrioritaires >= 3) {
                    return back()->withInput()->with('error', 'Impossible de rajouter un cinquième client prioritaire.');
                }
                $data['is_priority'] = true;
            } else {
                $data['is_priority'] = false;
            }

            // Gestion des suppressions d'images
            if ($request->has('remove_icon_image')) {
                if ($client->icon_image && Storage::disk('public')->exists($client->icon_image)) {
                    Storage::disk('public')->delete($client->icon_image);
                }
                $data['icon_image'] = null;
            }

            if ($request->has('remove_image')) {
                if ($client->image && Storage::disk('public')->exists($client->image)) {
                    Storage::disk('public')->delete($client->image);
                }
                $data['image'] = null;
            }

            // Gestion des nouvelles images
            $imageFields = ['image', 'icon_image'];
            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    if ($client->$field && Storage::disk('public')->exists($client->$field)) {
                        Storage::disk('public')->delete($client->$field);
                    }

                    $timestamp = time();
                    $extension = $request->file($field)->getClientOriginalExtension();
                    $fileName = "client_{$client->link}_{$timestamp}.{$extension}";

                    $path = $request->file($field)->storeAs(
                        $field === 'icon_image' ? 'assets/images/clients/icons' : 'assets/images/clients',
                        $fileName,
                        'public'
                    );

                    $data[$field] = $path;
                }
            }

            $client->update($data);

            DB::commit();
            return redirect()->route('client.index')->with('success', 'Client mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la mise à jour du client: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du client: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client): JsonResponse
    {
        try {
            DB::beginTransaction();

            $client->update([
                'deleted' => 1,
                'deleted_at' => now(),
                'deleted_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Le client '{$client->name}' a été supprimé avec succès"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la suppression du client: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue lors de la suppression du client"
            ], 500);
        }
    }

    public function data()
    {
        return Client::getDataForDataTable();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Statut;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'statut' => 'nullable|string|max:255',
            'statut_id' => 'nullable|exists:statuts,id'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $request->flash();
        return response()->view('back.contact.index',
            [
                'records' => Contact::all()->where('deleted', "0")
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        try {
            // Récupérer les statuts depuis la base de données
            $statutRecords = DB::table('statuts')
                ->where('deleted', '0')
                ->get();

            // Log pour le debugging
            \Log::info('Chargement des statuts pour le formulaire de contact', [
                'count' => $statutRecords->count()
            ]);

            return response()->view('back.contact.create', compact('statutRecords'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement du formulaire de contact', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors du chargement du formulaire');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function store(Request $request)
    {
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            Contact::create($request->all());
            Redirect::to(route('contact.index'))->send();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return Response
     */
    public function edit(Contact $contact): Response
    {
        // Récupérer les statuts disponibles
        $statutRecords = Statut::where('deleted', 0)->get();

        return response()->view('back.contact.edit', [
            'record' => $contact,
            'statutRecords' => $statutRecords,
            // Ajouter les autres variables nécessaires ici
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Contact $contact
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Contact $contact, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->getRules());
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $request->except(['_token', '_method']);

            // Remplacer statut_id par statut si nécessaire
            if (isset($data['statut_id'])) {
                $data['statut'] = $data['statut_id'];
                unset($data['statut_id']);
            }

            $contact->update($data);

            DB::commit();

            \Log::info('Contact mis à jour avec succès', [
                'contact_id' => $contact->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('contact.index')
                ->with('success', 'Contact mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la mise à jour du contact', [
                'error' => $e->getMessage(),
                'contact_id' => $contact->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du contact');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }

    public function data()
    {
        return contact::getDataForDataTable();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Statut;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
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
        return response()->view('back.lead.index',
            [
                'records' => Lead::all()->where('deleted', "0")
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
        $viewsData = [
            'statutRecords' => Statut::all()
        ];
        return response()->view('back.lead.create', $viewsData);
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
            Lead::create($request->all());
            Redirect::to(route('lead.index'))->send();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Lead $lead
     * @return Response
     */
    public function edit(Lead $lead): Response
    {
        $viewsData = [
            'record' => $lead,
            'statutRecords' => Statut::all()
        ];
        return response()->view('back.lead.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Lead $lead
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Lead $lead, Request $request): RedirectResponse
    {
        //
        $data = $request->all();
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $lead->update($request->all());
            Redirect::to(route('lead.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lead $lead
     * @return JsonResponse
     */
    public function destroy(Lead $lead): JsonResponse
    {
        $lead->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function data()
            {
               return lead::getDataForDataTable();
            }

}

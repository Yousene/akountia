<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statut;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class StatutController extends Controller
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
        return response()->view('back.statut.index',
            [
                'records' => Statut::all()->where('deleted', "0")
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
        $viewsData = [];
        

        return response()->view('back.statut.create', $viewsData);
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
            Statut::create($request->all());
            Redirect::to(route('statut.index'))->send();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Statut $statut
     * @return Response
     */
    public function edit(Statut $statut): Response
    {
        $viewsData['record'] = $statut;
        

        return response()->view('back.statut.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Statut $statut
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Statut $statut, Request $request): RedirectResponse
    {
        //
        $data = $request->all();
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $statut->update($request->all());
            Redirect::to(route('statut.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Statut $statut
     * @return JsonResponse
     */
    public function destroy(Statut $statut): JsonResponse
    {
        $statut->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function data()
            {
               return statut::getDataForDataTable();
            }

}

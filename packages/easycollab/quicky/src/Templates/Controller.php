<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Model};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class {Model}Controller extends Controller
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
        return response()->view('back.{projetId}.index',
            [
                'records' => {Model}::all()->where('deleted', "0")
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
        {viewsData}
        return response()->view('back.{projetId}.create', $viewsData);
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
            {Model}::create($request->all());
            Redirect::to(route('{projetId}.index'))->send();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param {Model} ${projetId}
     * @return Response
     */
    public function edit({Model} ${projetId}): Response
    {
        $viewsData['record'] = ${projetId};
        {viewsData}
        return response()->view('back.{projetId}.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param {Model} ${projetId}
     * @param Request $request
     * @return RedirectResponse
     */
    public function update({Model} ${projetId}, Request $request): RedirectResponse
    {
        //
        $data = $request->all();
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            ${projetId}->update($request->all());
            Redirect::to(route('{projetId}.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param {Model} ${projetId}
     * @return JsonResponse
     */
    public function destroy({Model} ${projetId}): JsonResponse
    {
        ${projetId}->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    {serverSide}

}

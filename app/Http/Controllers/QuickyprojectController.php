<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quickyproject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class QuickyprojectController extends Controller
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
        return response()->view('back.quickyproject.index',
            [
                'records' => Quickyproject::all()->where('deleted', "0")
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
        return response()->view('back.quickyproject.create', $viewsData);
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
            Quickyproject::create($request->all());
            Redirect::to(route('quickyproject.index'))->send();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Quickyproject $quickyproject
     * @return Response
     */
    public function edit(Quickyproject $quickyproject): Response
    {
        $viewsData['record'] = $quickyproject;

        return response()->view('back.quickyproject.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Quickyproject $quickyproject
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Quickyproject $quickyproject, Request $request): RedirectResponse
    {
        //
        $data = $request->all();
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $quickyproject->update($request->all());
            Redirect::to(route('quickyproject.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Quickyproject $quickyproject
     * @return JsonResponse
     */
    public function destroy(Quickyproject $quickyproject): JsonResponse
    {
        $quickyproject->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function data()
            {
               return quickyproject::getDataForDataTable();
            }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rolepermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RolepermissionController extends Controller
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
        return response()->view('back.rolepermission.index',
            [
                'records' => Rolepermission::all()->where('deleted', "0")
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
        
		$viewsData['roleRecords'] = \App\Models\Role::all()->where('deleted','0');
		$viewsData['permissionRecords'] = \App\Models\Permission::all()->where('deleted','0');

        return response()->view('back.rolepermission.create', $viewsData);
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
            Rolepermission::create($request->all());
            Redirect::to(route('rolepermission.index'))->send();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Rolepermission $rolepermission
     * @return Response
     */
    public function edit(Rolepermission $rolepermission): Response
    {
        $viewsData['record'] = $rolepermission;
        
		$viewsData['roleRecords'] = \App\Models\Role::all()->where('deleted','0');
		$viewsData['permissionRecords'] = \App\Models\Permission::all()->where('deleted','0');

        return response()->view('back.rolepermission.edit', $viewsData);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Rolepermission $rolepermission
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Rolepermission $rolepermission, Request $request): RedirectResponse
    {
        //
        $data = $request->all();
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $rolepermission->update($request->all());
            Redirect::to(route('rolepermission.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rolepermission $rolepermission
     * @return JsonResponse
     */
    public function destroy(Rolepermission $rolepermission): JsonResponse
    {
        $rolepermission->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function data()
            {
               return rolepermission::getDataForDataTable();
            }

}

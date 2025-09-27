<?php

namespace App\Http\Controllers;

use App\Models\Fonctionnalite;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules()
    {
        return [
        ];
    }

    public function list(Request $request)
    {
        $request->flash();
        return view('back/role/list',
            [
                'records' => Role::all()->where('deleted', "0")
            ]
        );
    }

    public function create(Request $request)
    {
        //dd(\Auth::user()::hasRessource('SMenu Saisies des colis'), session('user_ressources'), session('user_routes'));
        //dd(session('user_routes'));
        if ($request->isMethod('post')) {
            $rules = [
                'label' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $role = new Role;
                $role->label = $request->all()["label"];
                $role->desc = $request->all()["desc"];
                $role->role = $request->all()["role"];
                $role->color = $request->all()["color"];
                $role->save();
                if (isset($request->all()['fonctionnalites'])) {
                    $role->fonctionnalites()->attach(Fonctionnalite::find($request->all()['fonctionnalites']));
                }
                if (isset($request->all()['permissions'])) {
                    $role->permissions()->attach(Permission::find($request->all()['permissions']));
                }
                Redirect::to(route('role_list'))->send();
            }
        }
        return view('back/role/create', [
            'fonctionnalites' => Fonctionnalite::all()->where('deleted', "0"),
            'permissions' => Permission::all()->where('deleted', "0")
        ]);
    }

    public function update(Role $role, Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $role->label = $request->all()["label"];
                $role->desc = $request->all()["desc"];
                $role->role = $request->all()["role"];
                $role->color = $request->all()["color"];
                $role->save();
                if (isset($request->all()['fonctionnalites'])) {
                    $role->fonctionnalites()->sync(Fonctionnalite::find($request->all()['fonctionnalites']));
                } else {
                    $role->fonctionnalites()->sync([]);
                }
                if (isset($request->all()['permissions'])) {
                    $role->permissions()->sync(Permission::find($request->all()['permissions']));
                } else {
                    $role->permissions()->sync([]);
                }

                Redirect::to(route('role_list'))->send();
            }
        }
        return view('back/role/update',
            [
                'record' => $role,
                'fonctionnalites' => Fonctionnalite::all()->where('deleted', "0"),
                'permissions' => Permission::all()->where('deleted', "0"),
            ]
        );
    }

    public function delete(Role $role)
    {
        $role->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => \Auth::user()->id]);
        return redirect()->back()->with('success', "L'enregistrement a été supprimé avec succès");
    }

}

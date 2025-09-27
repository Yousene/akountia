<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Http\Controllers\CrudActions;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class MenuController extends Controller
{
    use CrudActions;
    public $crudId = 'menu';
    public $viewsData = [];
    public function __construct()
    {
        $this->middleware('auth');
        $this->viewsData['menus'] = \App\Models\Menu::all()->where('deleted', '0');
    }

    public function list(Request $request)
    {
        $request->flash();
        $allMenus = Menu::where('deleted', '0')->orderBy('ordre', 'asc')->get();
        $topLevelItems = $allMenus->filter(function ($menu) {
            return $menu->parent_menu === null;
        });

        $nestedItems = $allMenus->reject(function ($menu) {
            return $menu->parent_menu === null;
        })->groupBy('parent_menu');

        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();

        return view('back.menu.list', [
            'topLevelItems' => $topLevelItems,
            'nestedItems' => $nestedItems,
            'originalData' => $allMenus,
            'ressources' => Ressource::all()->where('deleted', "0"),
            'routes' => $routeCollection
        ]);
    }

    public function update($recordId, Request $request)
    {
        $record = ($this->getClassName())::find($recordId);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $record->update($request->all());
                Redirect::to(route('menu_list'))->send();
            }
        }
        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
        $this->viewsData['record'] = $record;
        $this->viewsData['routes'] = $routeCollection;
        $this->viewsData['ressources'] = Ressource::all()->where('deleted', "0");
        return view('back/menu/update', $this->viewsData);
    }

    public function create(Request $request)
    {

        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
        if ($request->isMethod('post')) {
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                ($this->getClassName())::create($request->all());
                Redirect::to(route($this->crudId . '_list'))->send();
            }
        }
        $this->viewsData['routes'] = $routeCollection;
        $this->viewsData['ressources'] = Ressource::all()->where('deleted', "0");
        return view('back/' . $this->crudId . '/create', $this->viewsData);
    }



    protected function getRules()
    {
        return [];
    }

    public function updateOrder(Request $request)
    {
        $data = $request->json()->all();

        foreach ($data as $menuData) {
            $menu = Menu::where('deleted', '0')->where('id', $menuData["id"])->first();
            if ($menu) {
                $menu->ordre = $menuData["ordre"];
                $menu->parent_menu = $menuData["parent_id"];
                $menu->save();
            }
        }

        return response()->json(['success' => true]);
    }
}

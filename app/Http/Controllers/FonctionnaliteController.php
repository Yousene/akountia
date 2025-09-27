<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fonctionnalite;
use App\Models\Ressource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class FonctionnaliteController extends Controller
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

    public function list(Request $request){

        $request->flash();
        return view('back/fonctionnalite/list' ,
                                        [
                                            'records' => Fonctionnalite::all()->where('deleted',"0")
                                        ]
        );
    }

    public function create(Request $request){

        if ($request->isMethod('post')) {
            $rules = [];
            $validator =  Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                $id = Fonctionnalite::create($request->all());
                Redirect::to(route('fonctionnalite_update', ['fonctionnalite' => $id]))->send();
            }
        }
        $viewsData = [];

        return view('back/fonctionnalite/create', $viewsData);
    }

    public function update(Fonctionnalite $fonctionnalite, Request $request){

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                //$fonctionnalite->update($request->all());
                $fonctionnalite->name = $request->all()["name"];
                $fonctionnalite->desc = $request->all()["desc"];
                $fonctionnalite->save();

                if(isset($request->all()['ressources'])){
                    $fonctionnalite->ressources()->sync(Ressource::find($request->all()['ressources']));
                }
                else{
                    $fonctionnalite->ressources()->sync([]);
                }

                if (isset($request->all()['routes'])) {
                    $routes = $request->all()['routes'];
                    $routesRows = [];
                    foreach($routes as $route){
                        $routesRows[] = ['route' => $route, 'fonctionnalite_id' => $fonctionnalite->id];
                    }
                    \DB::table('fonctionnalites_routes')->where("fonctionnalite_id",$fonctionnalite->id)->delete();
                    \DB::table('fonctionnalites_routes')->insert(
                        $routesRows
                    );
                }
                Redirect::to(route('fonctionnalite_list'))->send();
            }
        }
        $viewsData['record'] = $fonctionnalite;
        $viewsData['ressources'] = Ressource::all()->where('deleted',"0");
        $viewsData['routes'] = \Illuminate\Support\Facades\Route::getRoutes();
        $viewsData['relatedRoutes'] = array_column(\DB::table('fonctionnalites_routes')->where("fonctionnalite_id",$fonctionnalite->id)->get()->toArray(), 'route');

        return view('back/fonctionnalite/update' , $viewsData);
    }

    public function delete(Fonctionnalite $fonctionnalite){
        $fonctionnalite->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => \Auth::user()->id]);
        return redirect()->back()->with('success', "L'enregistrement a été supprimé avec succès");
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Ville;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class ParametersController extends Controller
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

    public function globale(Request $request){
        $parameters = Parameter::find(1);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                $parameters->villes_depart = implode(",", $data['villes_depart'] ?? []);
                $parameters->tauxtva = $data['tauxtva'];
                $parameters->save();
                Redirect::to(route('parameters_globale'))->send();
            }            
        }
        $viewsData['record'] = $parameters;
        $viewsData['villes'] = Ville::getVilles();
        return view('back/parameter/globale', $viewsData);        
    }
}
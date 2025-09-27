<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class RessourceController extends Controller
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
        return view('back/ressource/list' , 
                                        [
                                            'records' => Ressource::all()->where('deleted',"0")
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
                Ressource::create($request->all());
                Redirect::to(route('ressource_list'))->send();
            }            
        }
        $viewsData = [];
        

        return view('back/ressource/create', $viewsData);        
    }

    public function update(Ressource $ressource, Request $request){

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                $ressource->update($request->all());
                Redirect::to(route('ressource_list'))->send();
            }            
        }
        $viewsData['record'] = $ressource;
        

        return view('back/ressource/update' , $viewsData);        
    }

    public function delete(Ressource $ressource){
        $ressource->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => \Auth::user()->id]);
        return redirect()->back()->with('success', "L'enregistrement a été supprimé avec succès");
    }

}
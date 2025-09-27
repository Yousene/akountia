<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

trait CrudActions {
    
    public function getClassName(){
        return '\App\Models\\' . ucfirst($this->crudId);
    }
    public function list(Request $request){
        //dd(\Auth::user());
        //dd(\Auth::user()::hasRessource('Tableau de bord'), session('user_ressources'), session('user_routes'));
        $request->flash();
        return view('back/'.$this->crudId.'/list' , 
                                        [
                                            'records' => ($this->getClassName())::all()->where('deleted',"0")
                                        ]
        );
    }

    public function delete($recordId){
        $record = ($this->getClassName())::find($recordId);
        $record->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => \Auth::user()->id]);
        return redirect()->back()->with('success', "L'enregistrement a été supprimé avec succès");
    }

    public function update($recordId, Request $request){
        $record = ($this->getClassName())::find($recordId);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                $record->update($request->all());
                Redirect::to(route($this->crudId.'_list'))->send();
            }            
        }
        $this->viewsData['record'] = $record;
        return view('back/'.$this->crudId.'/update' , $this->viewsData);        
    }
    
    public function create(Request $request){
        
        if ($request->isMethod('post')) { 
            $rules = [];
            $validator =  Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else{
                ($this->getClassName())::create($request->all());
                Redirect::to(route($this->crudId.'_list'))->send();
            }            
        }
        return view('back/'.$this->crudId.'/create', $this->viewsData);        
    }
}
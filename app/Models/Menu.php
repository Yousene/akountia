<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $guarded = [];

    public static function fetchAll(){
        return \DB::table("menus")
                    ->select("*")
                    ->leftJoin('menus as m', 'm.parent_menu', '=', 'menus.id')
                    ->where('menus.deleted','0')->get();
    }

    public function getSubMenus($id){
        return Menu::orderBy('ordre', 'ASC')
                    ->select("menus.*",
                        \DB::raw('ressources.name as ressource_name'))
                    ->leftJoin('ressources', 'ressources.id', '=', 'menus.ressource')
                    ->where('menus.deleted','0')
                    ->where('parent_menu', $id)->get();
        //return Menu::orderBy('ordre', 'ASC')->where('deleted','0')->where('parent_menu', $id)->get();
    }
    public static function getMenus(){
        
        return Menu::orderBy('ordre', 'ASC')
                    ->select("menus.*",
                        \DB::raw('ressources.name as ressource_name'))
                    ->leftJoin('ressources', 'ressources.id', '=', 'menus.ressource')
                    ->where('menus.deleted','0')->get();
    }

    public static function getMenuName($id){
        if(!is_numeric($id)){
            return "";
        }
        $menu = Menu::where('id',$id)->first();
        return $menu->titre ?? "";
    }

}
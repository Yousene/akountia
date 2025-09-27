<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrudActions;

class ApparenceController extends Controller
{
    use CrudActions;
    public $crudId = 'apparence';
    public $viewsData = [];
    public function __construct() 
    {
        

        $this->middleware('auth');
    }

    protected function getRules()
    {
        return [
        ];
    }
}
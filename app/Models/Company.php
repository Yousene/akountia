<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Company extends Model
{
    protected $table = 'companys';
    protected $guarded = [];

    


    public static function getDataForDataTable()
            {
                $query = self::query()->where('deleted', '0');

                return DataTables::of($query)
                    
                    ->addColumn('action', function ($company) {
                        return view('back.company.actions', compact('company'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

}

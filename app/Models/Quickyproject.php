<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Quickyproject extends Model
{
    protected $table = 'quickyprojects';
    protected $guarded = [];

    


    public static function getDataForDataTable()
        {
            $query = self::query()->where('deleted', '0');

            return DataTables::of($query)
                ->addColumn('action', function ($quickyproject) {
                    return view('back.quickyproject.actions', compact('quickyproject'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }
}

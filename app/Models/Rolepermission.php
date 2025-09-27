<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Rolepermission extends Model
{
    protected $table = 'rolepermissions';
    protected $guarded = [];

    public function roleDetail()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    public function permissionDetail()
    {
        return $this->belongsTo(\App\Models\Permission::class, 'permission_id');
    }


    public static function getDataForDataTable()
    {
        $query = self::with(['roleDetail', 'permissionDetail'])->where('deleted', '0');

        return DataTables::of($query)
            ->addColumn('role_id', function ($rolepermission) {
                return $rolepermission->roleDetail->label;
            })
            ->addColumn('permission_id', function ($rolepermission) {
                return $rolepermission->permissionDetail->name;
            })
            ->addColumn('action', function ($rolepermission) {
                return view('back.rolepermission.actions', compact('rolepermission'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $guarded = [];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rolepermissions');
    }

    public function assignedTo()
    {
        return $this->roles()->get();
    }

    public static function getDataForDataTable()
    {
        $query = self::query()->where('deleted', '0');

        return DataTables::of($query)
            ->editColumn('created_at', function ($permission) {
                // Format the created_at field to a readable format
                return date('Y-m-d H:i:s', strtotime($permission->created_at));
            })
            ->addColumn('assigned_to', function ($permission) {
                $roles = $permission->roles;
                $rolesHtml = ''; 
                foreach ($roles as $role) {
                    $edit_route = route('role_update',['role'=>$role->id]);
                    $rolesHtml .= "<a href=\"$edit_route\" <span class=\"badge bg-label-$role->color m-1\">" . $role->label . '</span></a>';
                }
                return $rolesHtml;
            })
            ->addColumn('action', function ($permission) {
                return view('back.permission.actions', compact('permission'))->render();
            })
            ->rawColumns(['action', 'assigned_to'])
            ->make(true);
    }
}

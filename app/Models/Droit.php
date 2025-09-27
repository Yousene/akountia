<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Droit extends Model
{
    protected $table = 'users_droits';
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_droits');
    }
}
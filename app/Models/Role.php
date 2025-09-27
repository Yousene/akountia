<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = [];

    public function droits()
    {
        return $this->belongsToMany(Droit::class, 'roles_droits');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'rolepermissions');
    }

    public static function fetchAll()
    {
        return self::all()->where('deleted', "0");
    }

    public function fonctionnalites()
    {
        return $this->belongsToMany(Fonctionnalite::class, 'roles_fonctionnalites');
    }

    public function users()
    {
        return $this->hasMany(User::class, "role", "id");
    }
}

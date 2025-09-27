<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fonctionnalite extends Model
{
    protected $table = 'fonctionnalites';
    protected $guarded = [];

    public function ressources()
    {
        return $this->belongsToMany(Ressource::class, 'fonctionnalites_ressources');
    }
    
}
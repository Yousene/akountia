<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Statut extends Model
{
    protected $table = 'statuts';
    protected $guarded = [];

    /**
     * Relation avec les contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(\App\Models\Contact::class);
    }

    public static function getDataForDataTable()
            {
                $query = self::query()->where('deleted', '0');

                return DataTables::of($query)

                    ->addColumn('action', function ($statut) {
                        return view('back.statut.actions', compact('statut'))->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

}

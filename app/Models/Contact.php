<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $guarded = [];

    /**
     * Relation avec le modèle Statut
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statutDetails(): BelongsTo
    {
        return $this->belongsTo(Statut::class, 'statut', 'id');
    }

    /**
     * Méthode pour formater le statut en badge
     *
     * @return string
     */

    public static function getDataForDataTable()
    {
        $query = self::with('statutDetails')
                    ->where('deleted', '0');

        return DataTables::of($query)
            ->addColumn('statut', function ($contact) {
                if ($contact->statutDetails) {
                    return '<span class="badge rounded-pill" style="background-color: ' .
                           e($contact->statutDetails->color) . '">' .
                           e($contact->statutDetails->label) .
                           '</span>';
                }
                return '<span class="badge rounded-pill bg-secondary">Non défini</span>';
            })
            ->editColumn('subject', function ($contact) {
                return '<span class="text-truncate d-inline-block" style="max-width: 150px;"
                        data-bs-toggle="tooltip" title="' . e($contact->subject) . '">
                        ' . e(Str::limit($contact->subject, 50)) . '
                        </span>';
            })
            ->editColumn('message', function ($contact) {
                return '<span class="text-truncate d-inline-block" style="max-width: 200px;"
                        data-bs-toggle="tooltip" title="' . e($contact->message) . '">
                        ' . e(Str::limit($contact->message, 100)) . '
                        </span>';
            })
            ->editColumn('email', function ($contact) {
                return '<a href="mailto:'.$contact->email.'">'.$contact->email.'</a>';
            })
            ->addColumn('action', function ($contact) {
                return view('back.contact.actions', compact('contact'))->render();
            })
            ->filterColumn('statut', function ($query, $keyword) {
                $query->whereHas('statutDetails', function ($q) use ($keyword) {
                    $q->where('label', 'like', "%{$keyword}%");
                });
            })
            ->order(function ($query) {
                if (request()->has('order')) {
                    $order = request()->order[0];
                    $columnIndex = $order['column'];
                    $direction = $order['dir'];

                    // Obtenir le nom de la colonne à partir de l'index
                    $columnName = request()->columns[$columnIndex]['data'];

                    $query->orderBy($columnName, $direction);
                } else {
                    $query->orderBy('updated_at', 'desc');
                }
            })
            ->rawColumns(['action', 'statut', 'subject', 'message', 'email'])
            ->make(true);
    }
}

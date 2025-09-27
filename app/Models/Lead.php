<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;
    protected $table = 'leads';
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

    public static function getDataForDataTable()
    {
        $query = self::with('statutDetails')
            ->where('deleted', '0');

        return DataTables::of($query)
            ->addColumn('statut', function ($lead) {
                if ($lead->statutDetails) {
                    return '<span class="badge rounded-pill" style="background-color: ' .
                        e($lead->statutDetails->color) . '">' .
                        e($lead->statutDetails->label) .
                        '</span>';
                }
                return '<span class="badge rounded-pill bg-secondary">Non défini</span>';
            })
            ->addColumn('type', function ($lead) {
                $badgeClass = $lead->type === 'Entreprise' ? 'badge bg-label-danger' : 'badge bg-label-secondary';
                return '<span class="' . $badgeClass . '">' . ucfirst($lead->type) . '</span>';
            })
            ->addColumn('city', function ($lead) {
                $cityColors = [
                    'Casablanca' => 'bg-label-primary',
                    'Rabat' => 'bg-label-info',
                    'Reste du monde' => 'bg-label-warning'
                ];
                $badgeClass = $cityColors[$lead->city] ?? 'bg-label-secondary';
                return '<span class="badge ' . $badgeClass . '">' . $lead->city . '</span>';
            })
            ->addColumn('course', function ($lead) {
                $shortCourse = strlen($lead->course) > 20 ? substr($lead->course, 0, 20) . '...' : $lead->course;
                return '<span data-bs-toggle="tooltip" title="' . $lead->course . '">' . $shortCourse . '</span>';
            })
            ->editColumn('email', function ($lead) {
                return '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
            })
            ->editColumn('phone', function ($lead) {
                return '<a href="tel:' . $lead->phone . '">' . $lead->phone . '</a>';
            })
            ->addColumn('action', function ($lead) {
                return view('back.lead.actions', compact('lead'))->render();
            })
            ->filterColumn('city', function ($query, $keyword) {
                if ($keyword) {
                    $query->where('city', 'like', "%{$keyword}%");
                }
            })
            ->filterColumn('type', function ($query, $keyword) {
                if ($keyword) {
                    $query->where('type', 'like', "%{$keyword}%");
                }
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
            ->rawColumns(['type', 'city', 'course', 'action', 'email', 'phone', 'statut'])
            ->make(true);
    }
}

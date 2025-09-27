<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    protected $table = 'reviews';
    protected $guarded = [];

    use HasFactory;

    public function courseDetail()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($review) {
            if (!$review->picture) {
                $review->picture = 'assets/images/reviews/' . ($review->genre === 'Femme' ? 'default-female.webp' : 'default-male.webp');
            }
        });
    }

    public static function getDataForDataTable()
    {
        $query = self::with(['courseDetail'])->where('deleted', '0');

        return DataTables::of($query)
            ->editColumn('name', function ($review) {
                return '<div class="d-flex align-items-center cursor-help" data-bs-toggle="tooltip" data-bs-placement="top" title="' . e($review->comment) . '">
                            <span class="ms-1">' . e($review->name) . '</span>
                            <i class="bx bx-info-circle text-primary ms-1 small"></i>
                        </div>';
            })
            ->editColumn('comment', function ($review) {
                return '<span class="text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="' .
                        e($review->comment) . '">' . e($review->comment) . '</span>';
            })
            ->editColumn('picture', function ($review) {
                if ($review->picture && Storage::disk('public')->exists($review->picture)) {
                    return '<a href="' . Storage::url($review->picture) . '" target="_blank">
                                <img src="' . Storage::url($review->picture) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->editColumn('validation', function ($review) {
                if ($review->validation) {
                    return '<span class="badge bg-success">Validé</span>';
                }
                return '<span class="badge bg-danger">Non validé</span>';
            })
            ->editColumn('rating', function ($review) {
                $fullStars = floor($review->rating);
                $halfStar = ($review->rating - $fullStars) >= 0.5;
                $emptyStars = 5 - ceil($review->rating);

                $html = '';
                // Étoiles pleines
                for ($i = 0; $i < $fullStars; $i++) {
                    $html .= '<i class="bx bxs-star text-warning"></i>';
                }
                // Demi-étoile si nécessaire
                if ($halfStar) {
                    $html .= '<i class="bx bxs-star-half text-warning"></i>';
                }
                // Étoiles vides
                for ($i = 0; $i < $emptyStars; $i++) {
                    $html .= '<i class="bx bx-star text-warning"></i>';
                }

                return '<div class="d-flex align-items-center" data-bs-toggle="tooltip" title="' . $review->rating . '">' .
                       $html .
                       '<span class="ms-1">(' . number_format($review->rating, 1) . ')</span></div>';
            })
            ->addColumn('course_id', function ($review) {
                return $review->courseDetail->name;
            })
            ->addColumn('action', function ($review) {
                return view('back.review.actions', compact('review'))->render();
            })
            ->filterColumn('course_id', function ($query, $keyword) {
                $query->whereHas('courseDetail', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'name', 'comment', 'picture', 'validation', 'rating'])
            ->make(true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorys';
    protected $guarded = [];

    public static function getDataForDataTable()
    {
        $query = self::query()->where('deleted', '0');

        return DataTables::of($query)
            ->editColumn('name', function ($category) {
                $frontUrl = env('FRONT_URL', 'https://afriqueacademy.vercel.app/');
                $fullUrl = $frontUrl . 'formations/' . $category->link;

                return '<div class="d-flex align-items-center">
                            <div class="cursor-help" data-bs-toggle="tooltip" data-bs-placement="top" title="' . e($category->short_description) . '">
                                <span class="ms-1">' . e($category->name) . '</span>
                                <i class="bx bx-info-circle text-primary ms-1 small"></i>
                            </div>
                            <a href="' . $fullUrl . '" target="_blank" class="text-primary ms-2">
                                <i class="bx bx-link-external"></i>
                            </a>
                        </div>';
            })
            ->addColumn('average_rating', function ($category) {
                $reviewStats = \App\Models\Course::where('category_id', $category->id)
                    ->where('deleted', '0')
                    ->withCount(['reviews' => function ($query) {
                        $query->where('deleted', 0)
                              ->where('validation', 1);
                    }])
                    ->with(['reviews' => function ($query) {
                        $query->where('deleted', 0)
                              ->where('validation', 1)
                              ->select('course_id', 'rating');
                    }])
                    ->get();

                $totalReviews = $reviewStats->sum('reviews_count');
                $averageRating = $reviewStats->flatMap->reviews->avg('rating');
                $averageRating = round($averageRating, 1);

                // Générer les étoiles HTML
                $starsHtml = '';
                if ($totalReviews === 0) {
                    $starsHtml = '<i class="bx bx-star text-warning"></i>' . str_repeat('<i class="bx bx-star text-warning"></i>', 4);
                    $ratingText = 'Aucun avis';
                } else {
                    $fullStars = floor($averageRating);
                    $halfStar = ($averageRating - $fullStars) >= 0.5;
                    $emptyStars = 5 - ceil($averageRating);

                    $starsHtml .= str_repeat('<i class="bx bxs-star text-warning"></i>', $fullStars);
                    if ($halfStar) {
                        $starsHtml .= '<i class="bx bxs-star-half text-warning"></i>';
                    }
                    $starsHtml .= str_repeat('<i class="bx bx-star text-warning"></i>', $emptyStars);
                    $ratingText = number_format($averageRating, 1) . ' (' . $totalReviews . ' avis)';
                }

                return '<div data-bs-toggle="tooltip" title="' . $ratingText . '">
                            ' . $starsHtml . '
                            <span class="ms-1 small">(' . $totalReviews . ')</span>
                        </div>';
            })
            ->editColumn('short_description', function ($category) {
                return '<span class="text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="' .
                        e($category->short_description) . '">' . e($category->short_description) . '</span>';
            })
            ->editColumn('background_image', function ($category) {
                if ($category->background_image && Storage::disk('public')->exists($category->background_image)) {
                    return '<a href="' . Storage::url($category->background_image) . '" target="_blank">
                                <img src="' . Storage::url($category->background_image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->editColumn('icon_image', function ($category) {
                if ($category->icon_image && Storage::disk('public')->exists($category->icon_image)) {
                    return '<a href="' . Storage::url($category->icon_image) . '" target="_blank">
                                <img src="' . Storage::url($category->icon_image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->editColumn('portrait_image', function ($category) {
                if ($category->portrait_image && Storage::disk('public')->exists($category->portrait_image)) {
                    return '<a href="' . Storage::url($category->portrait_image) . '" target="_blank">
                                <img src="' . Storage::url($category->portrait_image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->addColumn('action', function ($category) {
                return view('back.category.actions', compact('category'))->render();
            })
            ->rawColumns(['action', 'name', 'average_rating', 'short_description', 'background_image', 'icon_image', 'portrait_image'])
            ->make(true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->link)) {
                $category->link = Str::slug($category->name);
            }
        });
    }

    public function getImageUrl($field)
    {
        if ($this->$field && Storage::disk('public')->exists($this->$field)) {
            return asset($this->$field);
        }
        return null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory, Searchable;

    protected $table = 'courses';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'link',
        'category_id',
        'duration',
        'duration_unit',
        'is_certified',
        'icon_image',
        'sidebar_image',
        'description_image',
        'short_description',
        'description',
        'prerequisites',
        'objectives',
        'target_audience',
        'teaching_methods',
        // autres champs...
    ];

    /**
     * Relation avec la catégorie
     */
    public function categoryDetail(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relation avec les modules
     */
    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(CourseFaq::class)->orderBy('order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('validation', true)->where('deleted', 0);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? null;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public static function getDataForDataTable()
    {
        $query = self::with(['categoryDetail'])->where('deleted', '0');

        return DataTables::of($query)
            ->addColumn('category', function ($course) {
                return '<div class="d-flex align-items-center cursor-help" data-bs-toggle="tooltip" data-bs-placement="top" title="' . e($course->categoryDetail->name) . '">
                                   <a href="' . route('category.edit', ['category' => $course->category_id]) . '" class="text-body">
                                       ' . e($course->categoryDetail->name) . '
                                       <i class="bx bx-info-circle text-primary ms-1 small"></i>
                                   </a>
                               </div>';
            })
            ->editColumn('name', function ($course) {
                $certifiedIcon = $course->is_certified ? ' <i class="bx bxs-certification text-warning"></i>' : ' <i class="bx bx-certification"></i>';
                $limitedName = Str::limit($course->name, 50);
                return '<div class="d-flex align-items-center cursor-help" data-bs-toggle="tooltip" data-bs-placement="top" title="' . e($course->short_description) . '">' .
                    $certifiedIcon .
                    '<span class="ms-1">' . e($limitedName) . '</span>' .
                    '<i class="bx bx-info-circle text-primary ms-1 small"></i>' .
                    '</div>';
            })
            ->editColumn('duration', function ($course) {
                $badgeClass = match (strtolower($course->duration_unit)) {
                    'heures', 'heure' => 'bg-label-info',
                    'jours', 'jour' => 'bg-label-primary',
                    'semaines', 'semaine' => 'bg-label-success',
                    'mois' => 'bg-label-warning',
                    default => 'bg-label-secondary'
                };

                return '<span class="badge ' . $badgeClass . '">
                                    <i class="bx bx-time-five me-1"></i>' .
                    $course->duration . ' ' . $course->duration_unit .
                    '</span>';
            })
            ->editColumn('icon_image', function ($course) {
                if ($course->icon_image && Storage::disk('public')->exists($course->icon_image)) {
                    return '<a href="' . Storage::url($course->icon_image) . '" target="_blank">
                                        <img src="' . Storage::url($course->icon_image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                                    </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->editColumn('average_rating', function ($course) {
                $averageRating = $course->average_rating ?? 0;
                $reviewsCount = $course->reviews_count ?? 0;

                // Si aucune évaluation
                if ($reviewsCount === 0) {
                    return '<div class="d-flex align-items-center" data-bs-toggle="tooltip" title="Aucune évaluation">' .
                           '<i class="bx bx-star text-warning"></i>' .
                           '<i class="bx bx-star text-warning"></i>' .
                           '<i class="bx bx-star text-warning"></i>' .
                           '<i class="bx bx-star text-warning"></i>' .
                           '<i class="bx bx-star text-warning"></i>' .
                           '<span class="ms-1">(Aucun avis)</span></div>';
                }

                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars) >= 0.5;
                $emptyStars = 5 - ceil($averageRating);

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

                $tooltipText = number_format($averageRating, 1) . ' sur 5 (' . $reviewsCount . ' avis)';

                return '<div class="d-flex align-items-center" data-bs-toggle="tooltip" title="' . $tooltipText . '">' .
                       $html .
                       '<span class="ms-1">(' . number_format($averageRating, 1) . ')</span></div>';
            })
            ->editColumn('updated_at', function ($course) {
                return $course->updated_at ? $course->updated_at->format('Y-m-d H:i:s') : null;
            })
            ->editColumn('link', function ($course) {
                $frontUrl = env('FRONT_URL', 'https://afriqueacademy.vercel.app/');
                \Log::info('Front URL: ' . $frontUrl); // Ajoutez cette ligne pour le logging
                $fullUrl = $frontUrl . 'formation/' . $course->link;
                return '<a href="' . $fullUrl . '" target="_blank" class="text-primary">
                                    <i class="bx bx-link-external me-1"></i>' .
                    e(Str::limit($course->link, 30)) .
                    '</a>';
            })

            ->filterColumn('category', function ($query, $keyword) {
                $query->whereHas('categoryDetail', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->addColumn('action', function ($course) {
                return view('back.course.actions', compact('course'))->render();
            })
            ->rawColumns(['action', 'icon_image', 'sidebar_image', 'description_image', 'name', 'duration', 'category', 'link', 'average_rating'])
            ->order(function ($query) {
                if (request()->has('order')) {
                    $order = request()->order[0];
                    $columnIndex = $order['column'];
                    $direction = $order['dir'];

                    // Obtenir le nom de la colonne à partir de l'index
                    $columnName = request()->columns[$columnIndex]['data'];

                    $query->orderBy($columnName, $direction);
                } else {
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->make(true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->link)) {
                $course->link = Str::slug($course->name);
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

    /**
     * Obtenir le tableau des attributs qui doivent être indexés par Algolia.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // Charger les relations nécessaires
        $this->load(['categoryDetail', 'modules']);

        // Préparer les données des modules de manière optimisée
        $modules = $this->modules->map(function ($module) {
            return [
                'title' => $module->title,
                'description' => Str::limit($module->description, 200), // Limiter la description
                'duration' => $module->duration,
                // Supprimer le contenu complet qui peut être très volumineux
            ];
        })->toArray();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'subtitle' => $this->subtitle,
            'description' => Str::limit($this->description, 500), // Limiter la description
            'short_description' => $this->short_description,
            'category_name' => $this->categoryDetail ? $this->categoryDetail->name : null,
            'duration' => $this->duration,
            'duration_unit' => $this->duration_unit,
            'is_certified' => $this->is_certified,
            'modules' => $modules,
            '_tags' => [
                $this->categoryDetail ? $this->categoryDetail->name : null,
                $this->is_certified ? 'certifié' : 'non certifié',
                $this->duration_unit
            ],
            'modules_text' => $this->getOptimizedModulesText($modules) // Nouvelle méthode
        ];
    }

    /**
     * Optimise le texte des modules pour la recherche
     *
     * @param array $modules
     * @return string
     */
    private function getOptimizedModulesText(array $modules): string
    {
        $texts = [];
        foreach ($modules as $module) {
            $texts[] = $module['title'];
            $texts[] = $module['description'];
        }
        return Str::limit(implode(' ', array_filter($texts)), 1000);
    }

    /**
     * Configure les options de recherche Algolia
     *
     * @return array
     */
    public function searchableOptions()
    {
        return [
            'attributesToIndex' => [
                'name',
                'subtitle',
                'description',
                'short_description',
                'category_name',
                'modules_text'
            ],
            'attributesForFaceting' => [
                'category_name',
                'is_certified',
                'duration_unit',
                '_tags'
            ]
        ];
    }

    /**
     * Obtenir le cours suivant
     *
     * @return Course|null
     */
    public function next()
    {
        return self::where('deleted', 0)
            ->where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Obtenir le cours précédent
     *
     * @return Course|null
     */
    public function previous()
    {
        return self::where('deleted', 0)
            ->where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }
}

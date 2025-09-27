<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $duration
 * @property mixed $duration_unit
 * @property mixed $is_certified
 * @property mixed $link
 * @property mixed $categoryDetail
 */
class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        // Récupérer la catégorie de manière sécurisée
        $category = $this->categoryDetail ?? null;

        // Calculer les statistiques des reviews
        $reviews = $this->reviews()
            ->where('deleted', 0)
            ->where('validation', 1);

        $averageRating = round($reviews->avg('rating'), 1);
        $bestReview = $reviews->max('rating');
        $worstReview = $reviews->min('rating');
        $reviewsCount = $reviews->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'subtitle' => $this->subtitle,
            'short_description' => $this->short_description,
            'description' => $this->description ?? '',
            'duration' => $this->duration,
            'duration_unit' => $this->duration_unit,
            'is_certified' => (bool) $this->is_certified,
            'category' => $category ? [
                'id' => $category->id,
                'name' => $category->name,
                'link' => $category->link,
                'updated_at' => $category->updated_at?->format('Y-m-d H:i:s')

            ] : null,
            'icon_image' => $this->icon_image ?? '',
            'reviews_stats' => [
                'average' => $averageRating,
                'best_rating' => $bestReview,
                'worst_rating' => $worstReview,
                'count' => $reviewsCount
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Personnalise la réponse de la collection pour inclure la pagination
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function collection($resource)
    {
        $data = parent::collection($resource);

        return [
            'items' => $data,
            'meta' => [
                'total' => $resource->total(),
                'per_page' => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
                'from' => $resource->firstItem(),
                'to' => $resource->lastItem()
            ],
            '_links' => [
                'self' => url()->current(),
                'first' => $resource->url(1),
                'last' => $resource->url($resource->lastPage()),
                'prev' => $resource->previousPageUrl(),
                'next' => $resource->nextPageUrl()
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $link
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'icon_image' => $this->icon_image,
            'background_image' => $this->background_image,
            'portrait_image' => $this->portrait_image,
            // 'description' => $this->description,
            'link' => $this->link,
            'courses_count' => Course::where('category_id', $this->id)
                ->where('deleted', '0')
                ->count(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
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

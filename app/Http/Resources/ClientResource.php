<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $link
 * @property mixed $icon_image
 * @property mixed $image
 */
class ClientResource extends JsonResource
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
            'link' => $this->link,
            'icon_image' => $this->icon_image ?? null,
            'image' => $this->image ?? null,
            'is_priority' => (bool) $this->is_priority,
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

        if (method_exists($resource, 'total')) {
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

        return ['data' => $data];
    }
}

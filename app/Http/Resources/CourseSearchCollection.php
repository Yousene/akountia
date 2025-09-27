<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseSearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $pagination = $this->resource;

        return [
            'success' => true,
            'data' => [
                'courses' => $this->collection,
                'meta' => [
                    'total' => $pagination->total(),
                    'query' => $request->query('query'),
                    'filters' => $this->getAppliedFilters($request),
                    'per_page' => $pagination->perPage(),
                    'current_page' => $pagination->currentPage(),
                    'last_page' => $pagination->lastPage(),
                    'from' => $pagination->firstItem() ?? 0,
                    'to' => $pagination->lastItem() ?? 0
                ]
            ]
        ];
    }

    /**
     * Récupère les filtres appliqués à la recherche
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function getAppliedFilters($request): array
    {
        $filters = [];

        if ($request->has('category_id')) {
            $filters[] = "category_id:{$request->category_id}";
        }

        if ($request->has('is_certified')) {
            $filters[] = "is_certified:{$request->is_certified}";
        }

        return $filters;
    }
}

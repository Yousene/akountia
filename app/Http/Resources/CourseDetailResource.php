<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource pour les détails complets d'un cours
 *
 * @property mixed $id
 * @property mixed $name
 * @property mixed $link
 * @property mixed $short_description
 * @property mixed $description
 * @property mixed $duration
 * @property mixed $duration_unit
 * @property mixed $objectives
 * @property mixed $target_audience
 * @property mixed $prerequisites
 * @property mixed $teaching_methods
 * @property mixed $icon_image
 * @property mixed $sidebar_image
 * @property mixed $description_image
 * @property mixed $is_certified
 * @property mixed $program
 * @property mixed $categoryDetail
 * @property mixed $faqs
 * @property mixed $average_rating
 * @property mixed $reviews_count
 */
class CourseDetailResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'duration' => [
                'value' => $this->duration,
                'unit' => $this->duration_unit,
            ],
            'objectives' => $this->formatTextContent($this->objectives),
            'target_audience' => $this->formatTextContent($this->target_audience),
            'prerequisites' => $this->formatTextContent($this->prerequisites),
            'teaching_methods' => $this->formatTextContent($this->teaching_methods),
            'images' => [
                'icon' => $this->icon_image,
                'sidebar' => $this->sidebar_image,
                'description' => $this->description_image,
            ],
            'is_certified' => (bool) $this->is_certified,
            'program' => [
                'modules' => $this->modules()
                    ->orderBy('order')
                    ->get()
                    ->map(function ($module) {
                        return [
                            'id' => $module->id,
                            'title' => $module->title,
                            'order' => $module->order,
                            'content' => $this->formatModuleContent($module->content)
                        ];
                    })
            ],
            'faqs' => $this->faqs()
                ->orderBy('order')
                ->get()
                ->map(function ($faq) {
                    return [
                        'id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'order' => $faq->order
                    ];
                }),
            'category' => new CategoryResource($this->whenLoaded('categoryDetail')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'reviews' => [
                'average' => round($this->average_rating, 1),
                'count' => $this->reviews_count,
                'items' => $this->reviews()
                    ->where('deleted', 0)
                    ->where('validation', 1)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'name' => $review->name,
                            'company' => $review->company,
                            'company_url' => $review->company_url,
                            'position' => $review->position,
                            'rating' => $review->rating,
                            'comment' => $review->comment,
                            'picture' => $review->picture,
                            'created_at' => $review->created_at?->format('Y-m-d H:i:s'),
                        ];
                    }),
            ],
        ];
    }

    /**
     * Formate le contenu du module
     *
     * @param string|null $content
     * @return array
     */
    protected function formatModuleContent(?string $content): array
    {
        if (empty($content) || $content === null) {
            return [];
        }

        // Divise le contenu en sections en utilisant les lignes vides comme séparateur
        $sections = preg_split('/\R\s*\R/', $content);

        // Nettoie chaque section et supprime les sections vides
        return array_values(array_filter(array_map('trim', $sections)));
    }

    /**
     * Formate le contenu texte en séparant les paragraphes
     *
     * @param string|null $content
     * @return array
     */
    private function formatTextContent(?string $content): array
    {
        if (empty($content)) {
            return [];
        }

        // Divise le texte en paragraphes en utilisant les lignes vides comme séparateur
        $paragraphs = preg_split('/\R\s*\R/', $content);

        // Nettoie chaque paragraphe et supprime les paragraphes vides
        return array_values(array_filter(array_map('trim', $paragraphs)));
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

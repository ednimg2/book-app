<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="BookResource",
 *     description="Book resource",
 *     @OA\Xml(
 *         name="BookResource"
 *     )
 * )
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Book[]
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'id' => $this->id,
            'sku' => $this->sku,
            'category_name' => $this->category ? $this->category->name : null,
            'viewed_count' => $this->viewed_count,
            'category' => $this->category,
            'language' => $this->language,
            'authors' => AuthorResource::collection($this->authors),
        ];
    }
}

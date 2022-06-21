<?php

namespace App\Http\Resources;

use App\Models\Auction;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="AuctionResource",
 *     description="Auction resource",
 *     @OA\Xml(
 *         name="AuctionResource"
 *     )
 * )
 */
class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Auction[]
     *
     */
    private $data;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->book->name,
            'price' => $this->price / 100,
            'currency' => 'EUR',
            'quantity' => $this->quantity,
        ];
    }
}

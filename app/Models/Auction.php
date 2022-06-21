<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     title="Auction",
 *     description="Auction model",
 *     @OA\Xml(
 *         name="Auction"
 *     )
 * )
 */
class Auction extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name description",
     *      example="Mindaugas"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Price",
     *      description="Price description",
     *      example="33.33"
     * )
     *
     * @var float
     */
    public $price;

    /**
     * @OA\Property(
     *      title="Currency",
     *      description="Currency description",
     *      example="EUR"
     * )
     *
     * @var string
     */
    public $currency;

    /**
     * @OA\Property(
     *      title="Quantity",
     *      description="Quantity description",
     *      example="3"
     * )
     *
     * @var integer
     */
    public $quantity;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}

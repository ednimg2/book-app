<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="BadApiRequest",
 *     description="BadApiRequest",
 *     @OA\Xml(
 *         name="BadApiRequest"
 *     )
 * )
 */
class BadApiRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="statusCode",
     *     example=404
     * )
     *
     * @var integer
     */
    private $statusCode;

    /**
     * @OA\Property(
     *     title="Message",
     *     example="string"
     * )
     *
     * @var string
     */
    private $message;
}

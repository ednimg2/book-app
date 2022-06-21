<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string|null $iban
 * @property int|null $year
 * @property string|null $pages
 * @property string|null $format
 * @property string|null $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $sku
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $viewed_count
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auction[] $auctions
 * @property-read int|null $auctions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @property-read \App\Models\Category $category
 * @method static \Database\Factories\BookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Query\Builder|Book onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereViewedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|Book withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Book withoutTrashed()
 * @mixin \Eloquent
 *
 * @OA\Schema(
 *     title="Book",
 *     description="Book model",
 *     @OA\Xml(
 *         name="Book"
 *     )
 * )
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;

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
     *      description="Book Name",
     *      example="Book name"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *      title="Category ID",
     *      description="Category ID",
     *      example=1
     * )
     *
     * @var integer
     */
    private $category_id;

    /**
     * @OA\Property(
     *      title="Category name",
     *      description="Category description",
     *      example="Category name"
     * )
     *
     * @var string
     */
    private $category_name;

    /**
     * @OA\Property(
     *      title="Category",
     *      description="Category ID",
     * )
     *
     * @var \App\Models\Category
     */
    private $category;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="Lorem ipsum"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *      title="IBAN",
     *      description="IBAN code",
     *      example="LS0320202"
     * )
     *
     * @var string
     */
    private $iban;

    /**
     * @OA\Property(
     *      title="Year",
     *      description="Year description",
     *      example=2022
     * )
     *
     * @var integer
     */
    private $year;

    /**
     * @OA\Property(
     *      title="Pages",
     *      description="Book pages description",
     *      example="220"
     * )
     *
     * @var string
     */
    private $pages;

    /**
     * @OA\Property(
     *      title="Format",
     *      description="Book format description",
     *      example="A5"
     * )
     *
     * @var string
     */
    private $format;

    /**
     * @OA\Property(
     *      title="Language",
     *      description="Book language description",
     *      example="lt"
     * )
     *
     * @var string
     */
    private $language;

    /**
     * @OA\Property(
     *      title="SKU",
     *      description="Book SKU description",
     *      example="RS345"
     * )
     *
     * @var string
     */
    private $sku;

    /**
     * @OA\Property(
     *      title="Authors",
     *      description="Authors description",
     * )
     *
     * @var \App\Models\Author[]
     */
    private $authors;

    /**
     * @OA\Property(
     *      title="Viewed count",
     *      description="Viewed count description",
     *      example=2
     * )
     *
     * @var integer
     */
    private $viewed_count;

    protected $fillable = [
        'name', 'category_id', 'description', 'iban', 'year', 'pages', 'format', 'language', 'sku'
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    //protected $with = ['category'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function auctions(): hasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function bookType(): Attribute
    {
        return new Attribute(fn() => 'SuperKnyga');
    }

    //
//    public function jsonSerialize(): array
//    {
//        return [
//            'name' => $this->name,
//            'description' => $this->description,
//            'sugalvojau' => 'tipas'
//        ];
//    }
}

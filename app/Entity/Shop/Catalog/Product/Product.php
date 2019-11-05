<?php

namespace App\Entity\Shop\Product;

use App\Entity\Shop\Catalog\Product\Category\CategoryRelation;
use Illuminate\Database\Eloquent\Model;
use App\Entity\Shop\Product\Image\Image;
use Illuminate\Database\Eloquent\Collection;
use App\Entity\Shop\Catalog\Category\Category;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Entity\Shop\Product\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $brand_id
 * @property int|null $featured
 * @property string|null $annotation
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereAnnotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property Collection $variants
 * @property Collection|Image[] images
 * @property int|null $is_active
 * @property int|null $is_featured
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Product\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Entity\Shop\Product\Image\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Product\Image\Image[] $images
 * @property-read int|null $images_count
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereIsFeatured($value)
 */
class Product extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'is_active',
        'is_featured',
        'annotation',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'sort',
    ];

    /**
     * Получить связи с категориями.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * Получить значения промежуточной таблицы связи с категориями.
     *
     * @return HasMany
     */
    public function categoryRelations(): HasMany
    {
        return $this->hasMany(CategoryRelation::class, 'product_id', 'id')->orderBy('sort');
    }

    /**
     * Получить связи с вариантами.
     *
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id', 'id')->orderBy('sort');
    }

    /**
     * Получить связи со свойствами.
     *
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    /**
     * Получить связи с изображениями.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id')->orderBy('sort');
    }

    /**
     * Получить связь с изображением.
     *
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'product_id', 'id')->orderBy('sort');
    }
}

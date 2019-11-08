<?php

namespace App\Entity\Shop\Catalog\Product\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Entity\Shop\Catalog\Category\Category;
use App\Entity\Shop\Catalog\Product\Image\Image;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Entity\Shop\Catalog\Product\Variant\Variant;
use App\Entity\Shop\Catalog\Product\Attribute\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot;

/**
 * App\Entity\Shop\Catalog\Product\Product\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $brand_id
 * @property int|null $is_active
 * @property int|null $is_featured
 * @property string|null $annotation
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Attribute\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot[] $categoryPivot
 * @property-read int|null $category_pivot_count
 * @property-read \App\Entity\Shop\Catalog\Product\Image\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Image\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Variant\Variant[] $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereAnnotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereBrandIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereJoinedCategory($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereJoinedCategoryNested($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use Scopes;

    protected $guarded  = ['id'];

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
     * Получить отношение к категориями.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * Получить связи промежуточной таблицы отношений к категориями.
     *
     * @return HasMany
     */
    public function categoryPivot(): HasMany
    {
        return $this->hasMany(CategoryPivot::class, 'product_id', 'id')
            ->orderBy('product_id')
            ->orderBy('sort');
    }

    /**
     * Получить значения промежуточной таблицы отношений к категориями.
     *
     * @return array
     */
    public function categoryPivotIds(): array
    {
        return $this->categoryPivot()->get()->pluck('category_id')->toArray();
    }

    /**
     * Получить отношение к вариантами.
     *
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id', 'id')->orderBy('sort');
    }

    /**
     * Получить отношение к свойствам.
     *
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    /**
     * Получить атрибуты сгруппированные по ID свойств.
     *
     * @return Collection|null
     */
    public function getAttributesGroupedByFeatureId(): ?Collection
    {
        return $this->attributes()->get()->groupBy('feature_id');
    }

    /**
     * Получить отношение к изображениям.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id')->orderBy('sort');
    }

    /**
     * Получить отношение к основному изображению.
     *
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'product_id', 'id')->where('sort', 0);
    }
}

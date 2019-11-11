<?php

namespace App\Entity\Shop\Catalog\Products\Product;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Model;
use App\Entity\Shop\Catalog\Brand\Brand;
use Illuminate\Database\Eloquent\Collection;
use App\Entity\Shop\Catalog\Category\Category;
use App\Entity\Shop\Catalog\Products\Image\Image;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Entity\Shop\Catalog\Products\Variant\Variant;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Entity\Shop\Catalog\Products\Attribute\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot;

/**
 * App\Entity\Shop\Catalog\Products\Product\Product
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Products\Attribute\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Entity\Shop\Catalog\Brand\Brand $brand
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot[] $categoryPivot
 * @property-read int|null $category_pivot_count
 * @property-read \App\Entity\Shop\Catalog\Products\Image\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Products\Image\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Products\Variant\Variant[] $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereAnnotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereBrandIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereJoinedCategory($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereJoinedCategoryNested($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereNameLike($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use Scopes;

    protected $table = Tables::SHOP_PRODUCTS;

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
    ];

    /**
     * Получить отношение к бренду.
     *
     * @return HasOne
     */
    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    /**
     * Получить отношение к категориями.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, Tables::SHOP_PRODUCT_CATEGORIES, 'product_id', 'category_id');
    }

    /**
     * Получить отношение к основной категории.
     *
     * @return HasOneThrough
     */
    public function category(): HasOneThrough
    {
        return $this->hasOneThrough(
            Category::class,
            ProductCategoryPivot::class,
            'product_id',
            'id',
            'id',
            'category_id'
        )->where(Tables::SHOP_PRODUCT_CATEGORIES . '.sort', 0);
    }

    /**
     * Получить связи промежуточной таблицы отношений к категориями.
     *
     * @return HasMany
     */
    public function categoryPivot(): HasMany
    {
        return $this->hasMany(ProductCategoryPivot::class, 'product_id', 'id')
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

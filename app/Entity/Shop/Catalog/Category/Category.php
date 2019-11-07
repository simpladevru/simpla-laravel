<?php

namespace App\Entity\Shop\Catalog\Category;

use App\Entity\Shop\Catalog\Product\Category\CategoryRelation;
use App\Entity\Shop\Product\Product;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use App\Entity\Shop\Feature\Feature;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\DescendantsRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Entity\Shop\Catalog\Category\Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $image
 * @property int|null $is_visible
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $sort
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $children
 * @property-read int|null $children_count
 * @property-read \App\Entity\Shop\Catalog\Category\Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Shop\Catalog\Category\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Shop\Catalog\Category\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Shop\Catalog\Category\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Category\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use NodeTrait;
    use Scopes;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'slug',
        'image',
        's_visible',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'parent_id',
    ];

    /**
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedUrl(int $width = 0, int $height = 0, bool $set_watermark = false)
    {
        if (!$this->image) {
            return '';
        }

        return app(ImageHelper::class)->getResizedUrl(
            'public',
            'categories',
            $this->image,
            $width,
            $height,
            $set_watermark
        );
    }

    /**
     * @return Collection
     */
    public function getAncestorsAndSelf()
    {
        return $this->getAncestors()->add($this);
    }

    /**
     * @return Collection
     */
    public function getDescendantsAndSelf()
    {
        return $this->getDescendants()->add($this);
    }

    /**
     * @return BelongsToMany
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            'category_features',
            'category_id',
            'feature_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return ProductRelation::build($this);
    }

    /**
     * @return HasMany
     */
    public function productRelations(): HasMany
    {
        return ProductPivotRelation::build($this);
    }
}

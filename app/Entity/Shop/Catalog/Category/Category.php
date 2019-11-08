<?php

namespace App\Entity\Shop\Catalog\Category;

use App\Helpers\ImageHelper;
use Kalnoy\Nestedset\NodeTrait;
use App\Entity\Shop\Feature\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

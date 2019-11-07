<?php

namespace App\Entity\Shop\Catalog\Product;

use Illuminate\Database\Eloquent\Builder;

trait Scopes
{
    /**
     * @param Builder $query
     * @param array $ids
     * @return Builder
     */
    public function scopeWhereBrandIds(Builder $query, array $ids)
    {
        return $query->whereIn('brand_id', $ids);
    }

    /**
     * @param Builder $query
     * @param array $ids
     * @return Builder
     */
    public function scopeWhereCategoryIds(Builder $query, array $ids)
    {
        return $query->whereHas('categoryRelations', function(Builder $query) use ($ids){
            $query->whereIn('id', $ids);
        });
    }
}

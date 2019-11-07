<?php

namespace App\Entity\Shop\Catalog\Product;

use Illuminate\Support\Facades\DB;
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

    /**
     * @param Builder $query
     * @param array $ids
     * @return Builder
     */
    public function scopeWhereCategoryIdsAndDescendants(Builder $query, array $ids)
    {
        return $query->whereHas('categories', function(Builder $query) use ($ids){
            $query->whereExists(function ($query) use ($ids) {
                $query->select('*')
                    ->from('categories', 'sc')
                    ->whereRaw('categories._lft between sc._lft and sc._rgt')
                    ->whereIn('sc.id', $ids);
            });
        });
    }
}

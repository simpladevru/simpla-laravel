<?php

namespace App\Entity\Shop\Catalog\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

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
        return $query->whereHas('categoryRelations', function (Builder $query) use ($ids) {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereCategoryIdsAndDescendants(Builder $query, array $ids)
    {
        $query
            ->join('product_categories as pc', 'product_id', 'id')
            ->whereIn('pc.category_id', $ids);
    }
}

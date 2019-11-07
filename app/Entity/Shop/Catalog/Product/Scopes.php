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
     * @return Builder
     */
    public function scopeWhereCategoryIdsAndDescendants(Builder $query, array $ids)
    {
        $query
            ->join('product_categories as pc', function (JoinClause $join) use ($ids) {
                $join
                    ->on('pc.product_id', '=', 'id')
                    ->whereIn('pc.product_id' , $ids);
            })
            ->join('categories as c', 'c.id', 'pc.category_id')
            ->whereIn('c.id', function ($query) {
                $query->from('categories')
                    ->selectRaw('id')
                    ->whereRaw('c._lft between categories._lft and categories._rgt');
            });
    }
}

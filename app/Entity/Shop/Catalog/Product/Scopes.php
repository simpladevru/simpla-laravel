<?php

namespace App\Entity\Shop\Catalog\Product;

use App\Helpers\Tables;
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
        $nestedSet = function ($query) use ($ids) {
            $query
                ->fromRaw('categories c, categories o')
                ->selectRaw('distinct c.id')
                ->whereIn('o.id', $ids)
                ->whereRaw('c._lft between o._lft and o._rgt');
        };

        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($nestedSet) {
            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $nestedSet);
        });

//        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($ids) {
//            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $ids);
//        });
    }
}

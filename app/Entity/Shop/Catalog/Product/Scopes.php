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
        //        $query->select('products.*');
        //
        //        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($ids) {
        //            $join->on('pc.product_id', 'id');
        //        });
        //
        //        $query->join('categories as nested_set_0', function (JoinClause $join) {
        //            $join->on('nested_set_0.id', 'pc.category_id');
        //        });
        //
        //        $query->join('categories as nested_set_1', function (JoinClause $join) use ($ids) {
        //            $join->whereIn('nested_set_1.id', $ids);
        //            $join->whereRaw('nested_set_0._lft between nested_set_1._lft and nested_set_1._rgt');
        //        });
        //
        //        $query->groupBy('products.id');

        $query->select('products.*');

        $nestedSet = function ($query) use ($ids) {
            $query
                ->fromRaw('categories nested_set_0, categories nested_set_1')
                ->selectRaw('distinct nested_set_0.id')
                ->whereIn('nested_set_1.id', $ids)
                ->whereRaw('nested_set_0._lft between nested_set_1._lft and nested_set_1._rgt');
        };

        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($nestedSet) {
            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $nestedSet);
        });

        $query->groupBy('products.id');

        //        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($ids) {
        //            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $ids);
        //        });
    }
}

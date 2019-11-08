<?php

namespace App\Entity\Shop\Catalog\Product\Product;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

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
    public function scopeWhereJoinedCategory(Builder $query, array $ids)
    {
        $query->select('products.*');

        $query->join(Tables::PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($ids) {
            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $ids);
        });

        $query->groupBy('products.id');
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategoryNested(Builder $query, array $ids)
    {
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
    }
}

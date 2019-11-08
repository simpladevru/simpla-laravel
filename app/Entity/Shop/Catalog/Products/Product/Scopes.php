<?php

namespace App\Entity\Shop\Catalog\Products\Product;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

trait Scopes
{
    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereBrandIds(Builder $query, array $ids)
    {
        $query->whereIn('brand_id', $ids);
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategory(Builder $query, array $ids)
    {
        $query->select(Tables::SHOP_PRODUCTS . '.*');

        $query->join(Tables::SHOP_PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($ids) {
            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $ids);
        });

        $query->groupBy(Tables::SHOP_PRODUCTS . '.id');
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategoryNested(Builder $query, array $ids)
    {
        $query->select(Tables::SHOP_PRODUCTS . '.*');

        $nestedSet = function ($query) use ($ids) {
            $query
                ->fromRaw(Tables::SHOP_CATEGORIES . ' nested_set_0, ' . Tables::SHOP_CATEGORIES . ' nested_set_1')
                ->selectRaw('distinct nested_set_0.id')
                ->whereIn('nested_set_1.id', $ids)
                ->whereRaw('nested_set_0._lft between nested_set_1._lft and nested_set_1._rgt');
        };

        $query->join(Tables::SHOP_PRODUCT_CATEGORIES . ' as pc', function (JoinClause $join) use ($nestedSet) {
            $join->on('pc.product_id', 'id')->whereIn('pc.category_id', $nestedSet);
        });

        $query->groupBy(Tables::SHOP_PRODUCTS . '.id');
    }

    /**
     * @param Builder $query
     * @param string $name
     */
    public function scopeWhereNameLike(Builder $query, string $name)
    {
        $words = explode(' ', $name);

        foreach ($words as $word) {
            $word = trim($word);

            if ($word) {
                $query->where('name', 'like', '%' . $word . '%');
            }
        }
    }
}

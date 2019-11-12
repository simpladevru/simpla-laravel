<?php

namespace App\Entity\Shop\Catalog\Products\Product;

use App\Helpers\Tables;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Category\Category;
use Illuminate\Database\Query\Builder as QueryBuilder;

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
     * @param Category $category
     */
    public function scopeForCategory(Builder $query, Category $category)
    {
        $query->whereHas('categoryPivot', function (Builder $query) use ($category) {
            $query->where('category_id', $category->id);
        });
    }

    /**
     * @param Builder $query
     * @param Category $category
     */
    public function scopeForCategoryNested(Builder $query, Category $category)
    {
        $query->whereHas('categoryPivot', function (Builder $query) use ($category) {
            $query->whereIn('category_id', $category->getDescendantsAndSelf()->pluck('id')->toArray());
        });
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategory(Builder $query, array $ids)
    {
        $query->whereHas('categoryPivot', function (Builder $query) use ($ids) {
            $query->whereIn('category_id', $ids);
        });
    }

    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategoryNested(Builder $query, array $ids)
    {
        $query->whereHas('categoryPivot', function (Builder $query) use ($ids) {
            $query->whereExists(function (QueryBuilder $query)  use ($ids) {
                $query
                    ->fromRaw(Tables::SHOP_CATEGORIES . ' nested_set_0, ' . Tables::SHOP_CATEGORIES . ' nested_set_1')
                    ->whereIn('nested_set_1.id', $ids)
                    ->whereRaw('shop_product_categories.category_id = nested_set_0.id')
                    ->whereRaw('nested_set_0._lft between nested_set_1._lft and nested_set_1._rgt');
            });
        });
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

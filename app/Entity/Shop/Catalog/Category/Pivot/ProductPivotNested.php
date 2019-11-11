<?php

namespace App\Entity\Shop\Catalog\Category\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot;

class ProductPivotNested extends HasMany
{
    /**
     * @param $parent
     * @return ProductPivotNested
     */
    public static function build($parent)
    {
        $query      = (new ProductCategoryPivot)->newQuery();
        $foreignKey = 'category_id';
        $localKey   = 'id';

        return new static($query, $parent, $foreignKey, $localKey);
    }

    /**
     * @param Builder $query
     * @param Builder $parentQuery
     * @return Builder
     */
    public function getRelationExistenceCountQuery(Builder $query, Builder $parentQuery)
    {
        return $this->getRelationExistenceQuery(
            $query, $parentQuery, new Expression('count(distinct ' . Tables::SHOP_PRODUCT_CATEGORIES . '.product_id)')
        )->setBindings([], 'select');
    }

    /**
     * @param Builder $query
     * @param Builder $parentQuery
     * @param array $columns
     * @return Builder
     */
    public function getRelationExistenceQuery(Builder $query, Builder $parentQuery, $columns = ['*'])
    {
        $query
            ->select($columns)
            ->join(Tables::SHOP_CATEGORIES . ' as sc', 'sc.id', Tables::SHOP_PRODUCT_CATEGORIES . '.category_id')
            ->whereRaw('sc._lft between ' . Tables::SHOP_CATEGORIES . '._lft and ' . Tables::SHOP_CATEGORIES . '._rgt');

        return $query;
    }
}

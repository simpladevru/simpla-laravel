<?php

namespace App\Entity\Shop\Catalog\Category;

use Illuminate\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot;

class ProductPivotRelation extends HasMany
{
    /**
     * @param $parent
     * @return ProductPivotRelation
     */
    public static function build($parent)
    {
        $query      = (new CategoryPivot)->newQuery();
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
            $query, $parentQuery, new Expression('count(distinct product_categories.product_id)')
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
            ->join('categories as sc', 'sc.id', 'product_categories.category_id')
            ->whereRaw('sc._lft between categories._lft and categories._rgt');

        return $query;
    }
}

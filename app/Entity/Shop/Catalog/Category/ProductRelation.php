<?php

namespace App\Entity\Shop\Catalog\Category;

use App\Entity\Shop\Products\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductRelation extends BelongsToMany
{
    /**
     * @param $parent
     * @return ProductRelation
     */
    public static function build($parent)
    {
        $query           = (new Product)->newQuery();
        $table           = 'product_categories';
        $foreignPivotKey = 'category_id';
        $relatedPivotKey = 'product_id';
        $parentKey       = 'id';
        $relatedKey      = 'id';
        $relationName    = 'products';

        return new static(
            $query,
            $parent,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relationName
        );
    }
}

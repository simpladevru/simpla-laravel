<?php

namespace App\Entity\Shop\Catalog\Product\Category;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Entity\Shop\Catalog\Product\Category\CategoryRelation
 *
 * @property int $product_id
 * @property int $category_id
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Category\CategoryRelation whereSort($value)
 * @mixin \Eloquent
 */
class CategoryRelation extends Pivot
{
    protected $table = Tables::PRODUCT_CATEGORIES;
}

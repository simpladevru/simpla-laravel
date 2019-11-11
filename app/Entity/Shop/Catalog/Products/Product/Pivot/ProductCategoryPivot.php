<?php

namespace App\Entity\Shop\Catalog\Products\Product\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot
 *
 * @property int $product_id
 * @property int $category_id
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\ProductCategoryPivot whereSort($value)
 * @mixin \Eloquent
 */
class ProductCategoryPivot extends Pivot
{
    protected $table = Tables::SHOP_PRODUCT_CATEGORIES;
}

<?php

namespace App\Entity\Shop\Catalog\Products\Product\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductCategoryPivot extends Pivot
{
    protected $table = Tables::SHOP_PRODUCT_CATEGORIES;
}

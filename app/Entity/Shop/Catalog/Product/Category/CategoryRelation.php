<?php

namespace App\Entity\Shop\Catalog\Product\Category;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryRelation extends Pivot
{
    protected $table = Tables::PRODUCT_CATEGORIES;
}

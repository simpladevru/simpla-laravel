<?php

namespace App\Entity\Shop\Catalog\Category\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryFeaturePivot extends Pivot
{
    protected $table = Tables::SHOP_CATEGORY_FEATURES;
    public $timestamps = null;
}

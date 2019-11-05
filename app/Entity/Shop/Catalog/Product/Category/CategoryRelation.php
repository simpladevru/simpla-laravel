<?php

namespace App\Entity\Shop\Catalog\Product\Category;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Model;

class CategoryRelation extends Model
{
    protected $table = Tables::PRODUCT_CATEGORIES;
}

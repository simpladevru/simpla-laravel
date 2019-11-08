<?php

namespace App\Entity\Shop\Catalog\Products\Attribute;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table   = Tables::SHOP_PRODUCT_ATTRIBUTES;

    protected $guarded = ['id'];
}

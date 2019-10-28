<?php

namespace App\Entity\Shop\Catalog\Product;

use Illuminate\Support\Str;
use App\Entity\Shop\Product\Product;

class ProductObserver
{
    /**
     * @param Product $product
     */
    public function saving(Product $product)
    {
        if ($product->slug == '') {
            $product->slug = Str::slug($product->name);
        }
    }
}
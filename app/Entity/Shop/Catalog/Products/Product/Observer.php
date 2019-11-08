<?php

namespace App\Entity\Shop\Catalog\Products\Product;

use Illuminate\Support\Str;
use App\Entity\Shop\Catalog\Products\Image\Image;
use App\Entity\Shop\Catalog\Products\Variant\Variant;
use App\Entity\Shop\Catalog\Products\Attribute\Attribute;

class Observer
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

    /**
     * @param Product $product
     */
    public function deleting(Product $product)
    {
        $product->images->map(function (Image $image) {
            $image->delete();
        });

        $product->variants->map(function (Variant $variant) {
            $variant->delete();
        });

        $product->attributes->map(function (Attribute $attribute) {
            $attribute->delete();
        });
    }
}

<?php

namespace App\Entity\Shop\Catalog\Product;

use Illuminate\Support\Str;
use App\Entity\Shop\Product\Product;
use App\Entity\Shop\Product\Variant;
use App\Entity\Shop\Product\Attribute;
use App\Entity\Shop\Product\Image\Image;

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
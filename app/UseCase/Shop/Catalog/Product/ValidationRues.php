<?php

namespace App\UseCase\Shop\Catalog\Product;

use App\Helpers\Tables;
use App\Entity\Shop\Catalog\Products\Product\Product;

class ValidationRues
{
    /**
     * @param Product|null $product
     * @return array
     */
    public static function adminRules(Product $product = null): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:500|unique:' . Tables::SHOP_PRODUCTS . ',slug' . ($product ? ',' . $product->id : null),
            'brand_id'         => 'nullable|integer|exists:' . Tables::SHOP_BRANDS . ',id',
            'is_active'        => 'boolean',
            'is_featured'      => 'boolean',
            'annotation'       => 'nullable|string',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',

            'category_ids.*' => 'nullable|integer|exists:' . Tables::SHOP_CATEGORIES . ',id',

            'variants.*.id'            => 'nullable|integer',
            'variants.*.name'          => 'nullable|string|max:255',
            'variants.*.sku'           => 'nullable|string|max:255',
            'variants.*.stock'         => 'nullable|integer',
            'variants.*.price'         => "required|regex:/^\d*(\.\d{1,2})?$/",
            'variants.*.compare_price' => "nullable|regex:/^\d*(\.\d{1,2})?$/",

            'attributes.*.*.id'         => 'nullable|integer',
            'attributes.*.*.feature_id' => 'nullable|integer',
            'attributes.*.*.value'      => 'nullable|string|max:255',

            'images'   => 'array',
            'images.*' => 'nullable|integer',

            'upload_images.*' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}

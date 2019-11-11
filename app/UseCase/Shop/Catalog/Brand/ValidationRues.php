<?php

namespace App\UseCase\Shop\Catalog\Brand;

use App\Helpers\Tables;
use App\Entity\Shop\Catalog\Brand\Brand;

class ValidationRues
{
    /**
     * @param Brand|null $brand
     * @return array
     */
    public static function adminRequest(Brand $brand = null): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:500|unique:' . Tables::SHOP_BRANDS . ',slug' . ($brand ? ',' . $brand->id : null),
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'image'            => 'nullable|string',
            'upload_image'     => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}

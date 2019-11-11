<?php

namespace App\UseCase\Shop\Catalog\Category;

use App\Helpers\Tables;
use App\Entity\Shop\Catalog\Category\Category;

class ValidationRues
{
    /**
     * @param Category|null $category
     * @return array
     */
    public static function adminRequest(Category $category = null): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:500|unique:' . Tables::SHOP_CATEGORIES . ',slug' . ($category ? ',' . $category->id : null),
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'parent_id'        => 'nullable|integer|exists:' . Tables::SHOP_CATEGORIES . ',id',
            'image'            => 'nullable|string',
            'upload_image'     => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}

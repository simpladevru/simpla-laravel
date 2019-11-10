<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use App\Helpers\Tables;
use Illuminate\Foundation\Http\FormRequest;
use App\Entity\Shop\Catalog\Category\Category;

/**
 * @property Category $category
 */
class CategoryRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:500|unique:' . Tables::SHOP_CATEGORIES . ',slug' . ($this->category ? ',' . $this->category->id : null),
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'parent_id'        => 'nullable|integer|exists:' . Tables::SHOP_CATEGORIES . ',id',
            'image'            => 'nullable|string',
            'upload_image'     => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        $data = parent::validated();

        $data['is_active'] = $this->has('is_active');
        $data['image']     = $this->file('upload_image', $this->get('image'));

        return $data;
    }
}

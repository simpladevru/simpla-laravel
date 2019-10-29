<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:500',

            'description' => 'nullable|string',

            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',

            'parent_id' => 'nullable|int',

            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }

    /**
     * @return array|void
     */
    public function validated(): array
    {
        $data = parent::validated();

        $data['is_active'] = $this->has('is_active');
        $data['image']     = $this->get('image', null);

        return $data;
    }
}

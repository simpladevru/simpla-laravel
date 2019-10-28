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
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:500',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',

            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:500',
            'brand_id'         => 'nullable|integer|exists:brands,id',
            'is_active'        => 'boolean',
            'is_featured'      => 'boolean',
            'annotation'       => 'nullable|string',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'sort'             => 'required|integer',

            'category_ids.*' => 'nullable|integer|exists:categories,id',

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

    /**
     * @return array
     */
    public function validated(): array
    {
        $data = parent::validated();

        $data['is_active']   = $this->has('is_active');
        $data['is_featured'] = $this->has('is_featured');

        $data['category_ids'] = $this->get('category_ids', []);
        $data['variants']     = $this->get('variants', []);
        $data['attributes']   = $this->get('attributes', []);

        $data['images']        = array_filter($this->get('images', []));
        $data['upload_images'] = $this->file('upload_images', []);

        return $data;
    }
}

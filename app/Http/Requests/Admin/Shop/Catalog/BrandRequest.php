<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use App\Entity\Shop\Catalog\Brand;
use App\Helpers\Tables;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Brand $brand
 */
class BrandRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:500|unique:' . Tables::SHOP_BRANDS . ',slug' . ($this->brand ? ',' . $this->brand->id : null),
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
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

        $data['image'] = $this->file('upload_image', $this->get('image'));

        return $data;
    }
}

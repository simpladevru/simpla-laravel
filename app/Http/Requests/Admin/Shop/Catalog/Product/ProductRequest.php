<?php

namespace App\Http\Requests\Admin\Shop\Catalog\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\UseCase\Shop\Catalog\Product\ValidationRues;
use App\Entity\Shop\Catalog\Products\Product\Product;

/**
 * @property Product $product
 */
class ProductRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return ValidationRues::adminRequest($this->product);
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

        $data['exist_image_ids'] = array_filter($this->get('exist_image_ids', []));
        $data['upload_images']   = $this->file('upload_images', []);

        return $data;
    }
}

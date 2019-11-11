<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use App\Entity\Shop\Catalog\Brand;
use Illuminate\Foundation\Http\FormRequest;
use App\UseCase\Shop\Catalog\Brand\ValidationRues;

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
        return ValidationRues::adminRequest($this->brand);
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

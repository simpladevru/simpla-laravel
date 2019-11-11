<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use App\Entity\Shop\Catalog\Category\Category;
use App\UseCase\Shop\Catalog\Category\ValidationRues;

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
        return ValidationRues::adminRequest($this->category);
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

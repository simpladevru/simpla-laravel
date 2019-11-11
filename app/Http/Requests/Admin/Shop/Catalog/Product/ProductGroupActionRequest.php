<?php

namespace App\Http\Requests\Admin\Shop\Catalog\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\UseCase\Shop\Catalog\Product\ValidationRues;

class ProductGroupActionRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return ValidationRues::adminGroupActionRequest();
    }
}

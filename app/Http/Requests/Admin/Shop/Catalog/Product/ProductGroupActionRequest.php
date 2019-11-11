<?php

namespace App\Http\Requests\Admin\Shop\Catalog\Product;

use App\UseCase\Shop\Catalog\Product\ValidationRues;
use Illuminate\Foundation\Http\FormRequest;

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

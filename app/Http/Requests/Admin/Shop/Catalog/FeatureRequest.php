<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use App\UseCase\Shop\Catalog\Feature\ValidationRules;

class FeatureRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return ValidationRules::adminRequest();
    }

    /**
     * @return array
     */
    public function validated()
    {
        $data = parent::validated();

        $data['in_filter']    = $this->has('in_filter');
        $data['category_ids'] = $this->get('category_ids', []);

        return $data;
    }
}

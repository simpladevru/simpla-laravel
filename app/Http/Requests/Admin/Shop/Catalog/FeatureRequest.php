<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use App\UseCase\Shop\Catalog\Feature\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return ValidationRules::adminRules();
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

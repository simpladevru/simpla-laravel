<?php

namespace App\Http\Requests\Admin\Shop\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort'      => 'required|integer',

            'category_ids.*' => 'nullable|integer',
        ];
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

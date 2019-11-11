<?php

namespace App\UseCase\Shop\Catalog\Feature;

class ValidationRules
{
    /**
     * @return array
     */
    public static function adminRequest(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'is_active'      => 'boolean',
            'sort'           => 'required|integer',
            'category_ids.*' => 'nullable|integer',
        ];
    }
}

<?php

namespace App\UseCase\Shop\Catalog\Feature\Handlers;

use App\Entity\Shop\Catalog\Feature\Feature;

class CategoriesHandler
{
    /**
     * Обновить список категорий в которых используется свойство.
     *
     * @param Feature $feature
     * @param array $categoryIds
     */
    public function update(Feature $feature, array $categoryIds = []): void
    {
        $feature->categories()->detach();

        foreach ($categoryIds as $categoryId) {
            $feature->categories()->attach($categoryId);
        }
    }
}
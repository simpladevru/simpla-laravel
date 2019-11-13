<?php

namespace App\UseCase\Shop\Catalog\Product\Handlers;

use App\Entity\Shop\Catalog\Products\Product\Product;

class CategoriesHandler
{
    /**
     * Обновить список категорий в которых присутствует товар.
     *
     * @param Product $product
     * @param array $categoryIds
     */
    public function update(Product $product, array $categoryIds = []): void
    {
        $product->categories()->detach();

        foreach ($categoryIds as $index => $categoryId) {
            $product->categories()->attach($categoryId, ['sort' => $index]);
        }
    }
}
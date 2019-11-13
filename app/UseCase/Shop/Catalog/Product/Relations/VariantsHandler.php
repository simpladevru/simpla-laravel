<?php

namespace App\UseCase\Shop\Catalog\Product\Relations;

use Throwable;
use App\Entity\Shop\Catalog\Products\Variant\Variant;
use App\Entity\Shop\Catalog\Products\Product\Product;

class VariantsHandler
{
    /**
     * Обновить варианты.
     *
     * @param Product $product
     * @param array $variants
     * @throws Throwable
     */
    public function update(Product $product, array $variants = []): void
    {
        $variantsRelation   = $product->variants();
        $variantsCollection = $variantsRelation->get()->keyBy('id');

        $existIds = [];

        foreach (array_values($variants) as $sort => $data) {
            $variant = $variantsCollection->get($data['id'], $variantsRelation->make());
            $variant->fill(array_merge($data, ['sort' => $sort]))->save();

            $existIds[] = $data['id'];
        }

        $variantsCollection->whereNotIn('id', array_filter($existIds))->map(function (Variant $variant) {
            $variant->delete();
        });
    }
}
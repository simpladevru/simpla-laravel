<?php

namespace App\UseCase\Shop\Catalog\Product\Handlers;

use App\Entity\Shop\Catalog\Products\Product\Product;
use App\Entity\Shop\Catalog\Products\Attribute\Attribute;

class AttributesHandler
{
    /**
     * Обновить характеристики.
     *
     * @param Product $product
     * @param array $attributes
     */
    public function updateGroupedByFeatureId(Product $product, array $attributes = []): void
    {
        $attributesRelation   = $product->attributes();
        $attributesCollection = $attributesRelation->get()->keyBy('id');

        $existIds = [];

        foreach ($attributes as $featureId => $values) {
            foreach ($values as $value) {
                if ($value['value']) {
                    $attribute = $attributesCollection->get($value['id'], $attributesRelation->make());
                    $attribute->fill(['feature_id' => $featureId, 'value' => $value['value'] ?? ''])->saveOrFail();

                    $existIds[] = $value['id'];
                }
            }
        }

        $attributesCollection->whereNotIn('id', array_filter($existIds))->map(function (Attribute $attribute) {
            $attribute->delete();
        });
    }
}
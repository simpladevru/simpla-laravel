<?php

namespace App\UseCase\Shop\Catalog\Product;

use App\Repositories\Shop\Catalog\VariantRepository;
use App\Entity\Shop\Catalog\Products\Variant\Variant;

class VariantService
{
    /**
     * @var VariantRepository
     */
    private $variants;

    /**
     * @param VariantRepository $variants
     */
    public function __construct(VariantRepository $variants)
    {
        $this->variants = $variants;
    }

    /**
     * Обновить список вариантов.
     *
     * @param array $variants
     */
    public function updateList(array $variants)
    {
        foreach ($variants as $variant) {
            $this->update($variant['id'], $variant);
        }
    }

    /**
     * Обновить вариант.
     *
     * @param int $id
     * @param array $attributes
     * @return Variant
     */
    public function update(int $id, array $attributes): Variant
    {
        $variant = $this->variants->getOne($id);
        $variant->update($attributes);

        return $variant;
    }
}

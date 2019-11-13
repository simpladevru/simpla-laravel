<?php

namespace App\UseCase\Shop\Catalog\Product;

use Throwable;
use Exception;
use DomainException;
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
     * Создать вариант.
     *
     * @param array $attributes
     * @return Variant
     */
    public function create(array $attributes): Variant
    {
        return Variant::create($attributes);
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

    /**
     * Удалить вариант.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->variants->getOne($id)->delete();
    }
}

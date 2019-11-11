<?php

namespace App\UseCase\Shop\Catalog\Variant;

use Exception;
use App\Repositories\Shop\Catalog\VariantRepository;
use App\Entity\Shop\Catalog\Products\Variant\Variant;

class VariantService
{
    /**
     * @var VariantRepository
     */
    private $repository;

    /**
     * @param VariantRepository $repository
     */
    public function __construct(VariantRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Обновить варианты сгруппированные по ID.
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
        $variant = $this->repository->getOne($id);
        $variant->update($attributes);

        return $variant;
    }

    /**
     * Заполнить вариант и сохранить.
     *
     * @param Variant $variant
     * @param array $attributes
     */
    public function fillAndSave(Variant $variant, array $attributes)
    {
        $variant->fill($attributes)->save();
    }

    /**
     * Удалить вариант.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->repository->getOne($id)->delete();
    }
}

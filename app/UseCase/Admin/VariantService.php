<?php

namespace App\UseCase\Admin;

use Exception;
use App\Entity\Shop\Product\Variant;
use App\Repositories\Shop\Catalog\VariantRepository;

class VariantService
{
    /**
     * @var VariantRepository
     */
    private $repository;

    /**
     * VariantService constructor.
     *
     * @param VariantRepository $repository
     */
    public function __construct(VariantRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $variants
     */
    public function updateGroupedByPrimaryKey(array $variants)
    {
        foreach ($variants as $variantId => $variant) {
            $this->update($variantId, $variant);
        }
    }

    /**
     * @param array $attributes
     * @return Variant
     */
    public function create(array $attributes): Variant
    {
        return Variant::create($attributes);
    }

    /**
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
     * @param Variant $variant
     * @param array $attributes
     */
    public function fillAndSave(Variant $variant, array $attributes)
    {
        $variant->fill($attributes)->save();
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->repository->getOne($id)->delete();
    }
}

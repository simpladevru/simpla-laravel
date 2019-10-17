<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use Throwable;
use Illuminate\Support\Arr;
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
     * @param array $data
     * @return Variant
     * @throws Throwable
     */
    public function create(array $data): Variant
    {
        return $this->fillAndSave(new Variant(), $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Variant
     * @throws Throwable
     */
    public function edit(int $id, array $data): Variant
    {
        return $this->fillAndSave($this->repository->getOne($id), $data);
    }

    /**
     * @param Variant $variant
     * @param array $data
     * @return Variant
     * @throws Throwable
     */
    public function fillAndSave(Variant $variant, array $data): Variant
    {
        $variant->fill(Arr::only($data, [
            'name',
            'sku',
            'stock',
            'price',
            'compare_price',
            'sort',
        ]))->saveOrFail();

        return $variant;
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

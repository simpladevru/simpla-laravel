<?php

namespace App\UseCase\Shop\Catalog\Brand;

use Exception;
use App\Entity\Shop\Catalog\Brand\Brand;
use App\Repositories\Shop\Catalog\BrandRepository;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * @param BrandRepository $brands
     */
    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    /**
     * Создать бренд.
     *
     * @param array $attributes
     * @return Brand
     */
    public function create(array $attributes): Brand
    {
        return Brand::create($attributes);
    }

    /**
     * Обновить бренд.
     *
     * @param int $id
     * @param array $attributes
     * @return Brand
     */
    public function update(int $id, array $attributes): Brand
    {
        $brand = $this->brands->getOne($id);
        $brand->update($attributes);

        return $brand;
    }

    /**
     * Удалить бренд.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id): void
    {
        $this->brands->getOne($id)->delete();
    }
}

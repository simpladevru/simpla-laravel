<?php

namespace App\UseCase\Admin;

use Exception;
use App\Entity\Shop\Catalog\Brand;
use App\Repositories\Shop\Catalog\BrandRepository;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * BrandService constructor.
     * @param BrandRepository $repository
     */
    public function __construct(BrandRepository $repository)
    {
        $this->brands = $repository;
    }

    /**
     * @param array $attributes
     * @return Brand
     */
    public function create(array $attributes): Brand
    {
        return Brand::create($attributes);
    }

    /**
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
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id): void
    {
        $this->brands->getOne($id)->delete();
    }
}

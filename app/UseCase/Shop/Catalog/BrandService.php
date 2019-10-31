<?php

namespace App\UseCase\Shop\Catalog;

use App\Entity\Shop\Catalog\Brand\BrandDto;
use App\Entity\Shop\Catalog\Feature\FeatureDto;
use App\Entity\Shop\Feature\Feature;
use App\Helpers\DtoHelper;
use Exception;
use App\Entity\Shop\Catalog\Brand;
use App\Repositories\Shop\Catalog\BrandRepository;
use App\Http\Requests\Admin\Shop\Catalog\BrandRequest;
use ReflectionException;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * BrandService constructor.
     *
     * @param BrandRepository $repository
     */
    public function __construct(BrandRepository $repository)
    {
        $this->brands = $repository;
    }

    /**
     * @param BrandDto $dto
     * @return Brand
     */
    public function create(BrandDto $dto): Brand
    {
        $brand = $this->fill(new Brand(), $dto);

        return $this->brands->save($brand);
    }

    /**
     * @param int $id
     * @param BrandDto $dto
     * @return Brand
     */
    public function edit(int $id, BrandDto $dto): Brand
    {
        $oldBrand = $this->brands->getOne($id);
        $newBrand = $this->fill($oldBrand, $dto);

        return $this->brands->save($newBrand);
    }

    /**
     * @param Brand $brand
     * @param BrandDto $dto
     * @return Brand
     */
    private function fill(Brand $brand, BrandDto $dto): Brand
    {
        return $brand->fill([
            'name'             => $dto->name,
            'slug'             => $dto->slug,
            'image'            => $dto->image,
            'description'      => $dto->description,
            'meta_title'       => $dto->meta_title,
            'meta_keywords'    => $dto->meta_keywords,
            'meta_description' => $dto->meta_description,
        ]);
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id): void
    {
        $this->brands->remove($id);
    }
}

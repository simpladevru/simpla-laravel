<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use App\Entity\Shop\Catalog\Brand;
use App\Entity\Shop\Catalog\Brand\BrandDto;
use App\Repositories\Shop\Catalog\BrandRepository;

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
        return $this->fillAndSave(new Brand(), $dto);
    }

    /**
     * @param int $id
     * @param BrandDto $dto
     * @return Brand
     */
    public function edit(int $id, BrandDto $dto): Brand
    {
        return $this->fillAndSave($this->brands->getOne($id), $dto);
    }

    /**
     * @param Brand $brand
     * @param BrandDto $dto
     * @return Brand
     */
    public function fillAndSave(Brand $brand, BrandDto $dto)
    {
        return $this->brands->save(
            $this->fill($brand, $dto)
        );
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

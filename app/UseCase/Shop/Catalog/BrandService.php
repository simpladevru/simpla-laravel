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
     * @throws Exception
     */
    public function create(BrandDto $dto): Brand
    {
        return $this->fillAndSave(new Brand(), $dto);
    }

    /**
     * @param int $id
     * @param BrandDto $dto
     * @return Brand
     * @throws Exception
     */
    public function edit(int $id, BrandDto $dto): Brand
    {
        return $this->fillAndSave($this->brands->getOne($id), $dto);
    }

    /**
     * @param Brand $brand
     * @param BrandDto $dto
     * @return Brand
     * @throws Exception
     */
    public function fillAndSave(Brand $brand, BrandDto $dto): Brand
    {
        $result = $this->brands->save(
            $this->fill($brand, $dto)
        );

        if (!$result) {
            throw new Exception('error');
        }

        return $brand;
    }

    /**
     * @param Brand $brand
     * @param BrandDto $dto
     * @return Brand
     */
    public function fill(Brand $brand, BrandDto $dto): Brand
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
     * @return bool
     * @throws Exception
     */
    public function remove(int $id): bool
    {
        return $this->brands->remove(
            $this->brands->getOne($id)
        );
    }
}

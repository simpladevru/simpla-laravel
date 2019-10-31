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
    private $repository;

    /**
     * BrandService constructor.
     *
     * @param BrandRepository $repository
     */
    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BrandRequest $request
     * @return Brand
     * @throws ReflectionException
     */
    public function create(BrandRequest $request): Brand
    {
        $brand = new Brand();
        $dto   = DtoHelper::arrayToDto($request->validated(), BrandDto::class);

        return $this->fillAndSave($brand, $dto);
    }

    /**
     * @param int $id
     * @param BrandRequest $request
     * @return Brand
     * @throws ReflectionException
     */
    public function edit(int $id, BrandRequest $request): Brand
    {
        $brand = $this->repository->getOne($id);
        $dto   = DtoHelper::arrayToDto($request->validated(), BrandDto::class);

        return $this->fillAndSave($brand, $dto);
    }

    /**
     * @param Brand $brand
     * @param BrandDto $dto
     * @return Brand
     */
    public function fillAndSave(Brand $brand, BrandDto $dto): Brand
    {
        $brand->fill([
            'name'             => $dto->name,
            'slug'             => $dto->slug,
            'image'            => $dto->image,
            'description'      => $dto->description,
            'meta_title'       => $dto->meta_title,
            'meta_keywords'    => $dto->meta_keywords,
            'meta_description' => $dto->meta_description,
        ])->save();

        return $brand;
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

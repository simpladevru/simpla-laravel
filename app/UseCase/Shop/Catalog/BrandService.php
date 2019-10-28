<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use App\Entity\Shop\Catalog\Brand;
use App\Repositories\Shop\Catalog\BrandRepository;
use App\Http\Requests\Admin\Shop\Catalog\BrandRequest;

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
     */
    public function create(BrandRequest $request): Brand
    {
        $data = $request->validated();

        $brand = Brand::create([
            'name'             => $data['name'],
            'slug'             => $data['slug'],
            'image'            => $data['image'],
            'description'      => $data['description'],
            'meta_title'       => $data['meta_title'],
            'meta_keywords'    => $data['meta_keywords'],
            'meta_description' => $data['meta_description'],
        ]);

        return $brand;
    }

    /**
     * @param int $id
     * @param BrandRequest $request
     * @return Brand
     */
    public function edit(int $id, BrandRequest $request): Brand
    {
        $brand = $this->repository->getOne($id);
        $data  = $request->validated();

        $brand->update([
            'name'             => $data['name'],
            'slug'             => $data['slug'],
            'image'            => $data['image'],
            'description'      => $data['description'],
            'meta_title'       => $data['meta_title'],
            'meta_keywords'    => $data['meta_keywords'],
            'meta_description' => $data['meta_description'],
        ]);

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

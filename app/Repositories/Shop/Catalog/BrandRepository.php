<?php

namespace App\Repositories\Shop\Catalog;

use App\Entity\Shop\Catalog\Brand;

class BrandRepository
{
    /**
     * @param int $id
     * @return Brand
     */
    public function getOne(int $id): Brand
    {
        return Brand::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Brand|null
     */
    public function findOne(int $id): ?Brand
    {
        return Brand::find($id);
    }

    /**
     * @param Brand $brand
     * @return Brand
     */
    public function save(Brand $brand): Brand
    {
        return $brand->save();
    }

    public function remove($id): void
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
    }
}

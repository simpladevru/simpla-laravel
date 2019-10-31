<?php

namespace App\Repositories\Shop\Catalog;

use Exception;
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
     * @return bool
     */
    public function save(Brand $brand): bool
    {
        return $brand->save();
    }

    /**
     * @param Brand $brand
     * @return bool|null
     * @throws Exception
     */
    public function remove(Brand $brand): bool
    {
        return $brand->delete();
    }
}

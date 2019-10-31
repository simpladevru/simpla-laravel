<?php

namespace App\Repositories\Shop\Catalog;

use Exception;
use RuntimeException;
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
     */
    public function save(Brand $brand): void
    {
        if (!$brand->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    /**
     * @param Brand $brand
     * @throws Exception
     */
    public function remove(Brand $brand): void
    {
        if (!$brand->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}

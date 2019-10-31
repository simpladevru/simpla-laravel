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
}

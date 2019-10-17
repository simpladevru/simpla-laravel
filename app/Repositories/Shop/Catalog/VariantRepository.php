<?php

namespace App\Repositories\Shop\Catalog;

use App\Entity\Shop\Product\Variant;

class VariantRepository
{
    /**
     * @param int $id
     * @return Variant
     */
    public function getOne(int $id): Variant
    {
        return Variant::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Variant|null
     */
    public function findOne(int $id): ?Variant
    {
        return Variant::find($id);
    }
}

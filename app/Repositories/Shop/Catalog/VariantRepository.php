<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Products\Variant\Variant;

class VariantRepository
{
    /**
     * @param int $id
     * @return Variant
     */
    public function getOne(int $id): Variant
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return Variant|null
     */
    public function findOne(int $id): ?Variant
    {
        return $this->query()->find($id);
    }

    /**
     * @return Variant|Builder
     */
    public function query(): Builder
    {
        return Variant::query();
    }
}

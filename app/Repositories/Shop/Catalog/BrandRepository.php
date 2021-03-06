<?php

namespace App\Repositories\Shop\Catalog;

use App\Entity\Shop\Catalog\Brand\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository
{
    /**
     * Получить бренд по ID.
     *
     * @param int $id
     * @return Brand
     */
    public function getOne(int $id): Brand
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Найти бренд по ID.
     *
     * @param int $id
     * @return Brand|null
     */
    public function findOne(int $id): ?Brand
    {
        return $this->query()->find($id);
    }

    /**
     * Получить все бренды.
     *
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->query()->get();
    }

    /**
     * @return Brand|Builder
     */
    public function query(): Builder
    {
        return Brand::query();
    }
}

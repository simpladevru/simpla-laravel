<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Support\Collection;
use App\Entity\Shop\Feature\Feature;

class FeatureRepository
{
    /**
     * @param int $id
     * @return Feature
     */
    public function getOne(int $id): Feature
    {
        return Feature::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Feature|null
     */
    public function findOne(int $id): ?Feature
    {
        return Feature::find($id);
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public function getByCategoryId(int $id): ?Collection
    {
        return Feature::get();
    }

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return Feature::get();
    }
}

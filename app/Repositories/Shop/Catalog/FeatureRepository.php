<?php

namespace App\Repositories\Shop\Catalog;

use App\Helpers\Tables;
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
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return Feature::get();
    }
}

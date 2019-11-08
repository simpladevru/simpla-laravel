<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Support\Collection;
use App\Entity\Shop\Feature\Feature;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @return Feature|Builder
     */
    public function query(): Builder
    {
        return Feature::query();
    }
}

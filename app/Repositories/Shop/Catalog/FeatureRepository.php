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
        return $this->query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return Feature|null
     */
    public function findOne(int $id): ?Feature
    {
        return $this->query()->find($id);
    }

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->query()->get();
    }

    /**
     * @return Feature|Builder
     */
    public function query(): Builder
    {
        return Feature::query();
    }
}

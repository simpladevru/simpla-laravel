<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Category\Category;

class CategoryRepository
{
    /**
     * @param int $id
     * @return Category
     */
    public function getOne(int $id): Category
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return Category|null
     */
    public function findOne(int $id): ?Category
    {
        return $this->query()->find($id);
    }

    /**
     * @param array|null $select
     * @return Collection|null
     */
    public function getAllWithDepth(array $select = ['*']): ?Collection
    {
        return $this->query()->defaultOrder()->select($select)->withDepth()->get();
    }

    /**
     * @return Category|Builder
     */
    public function query(): Builder
    {
        return Category::query();
    }
}

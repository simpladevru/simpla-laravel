<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Support\Collection;
use App\Entity\Shop\Catalog\Category\Category;

class CategoryRepository
{
    /**
     * @param int $id
     * @return Category
     */
    public function getOne(int $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Category|null
     */
    public function findOne(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * @return Collection|null
     */
    public function getAllWithDepth(): ?Collection
    {
        return Category::defaultOrder()->withDepth()->get();
    }
}

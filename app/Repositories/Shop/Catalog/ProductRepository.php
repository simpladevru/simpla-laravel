<?php

namespace App\Repositories\Shop\Catalog;

use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Products\Product\Product;

class ProductRepository
{
    /**
     * @param string $file
     * @return bool
     */
    public function existsByImageFile(string $file): bool
    {
        return $this->query()->whereHas('images', function ($query) use ($file) {
            $query->where('file', $file);
        })->exists();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getOne(int $id): Product
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function findOne(int $id): ?Product
    {
        return $this->query()->find($id);
    }

    /**
     * @return Product|Builder
     */
    public function query(): Builder
    {
        return Product::query();
    }
}

<?php

namespace App\Repositories\Shop\Catalog\Product;

use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Products\Product\Product;

class ProductRepository
{
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

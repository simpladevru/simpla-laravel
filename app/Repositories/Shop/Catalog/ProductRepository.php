<?php

namespace App\Repositories\Shop\Catalog;

use App\Entity\Shop\Product\Product;

class ProductRepository
{
    /**
     * @param int $id
     * @return Product
     */
    public function getOne(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function findOne(int $id): ?Product
    {
        return Product::find($id);
    }
}

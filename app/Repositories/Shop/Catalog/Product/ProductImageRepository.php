<?php

namespace App\Repositories\Shop\Catalog\Product;

use Illuminate\Database\Eloquent\Builder;
use App\Entity\Shop\Catalog\Products\Image\Image;

class ProductImageRepository
{
    /**
     * @param string $file
     * @return bool
     */
    public function existsByFile(string $file): bool
    {
        return $this->query()->where('file', $file)->exists();
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Image::query();
    }
}

<?php

namespace App\UseCase\Shop\Catalog\Product\Handlers;

use App\Entity\Shop\Catalog\Products\Image\Image;
use App\Entity\Shop\Catalog\Products\Product\Product;

class ImagesHandler
{
    /**
     * Обновить изображения.
     *
     * @param Product $product
     * @param array $existImageIds
     * @param array $uploads
     * @param array $downloads
     */
    public function update(Product $product, array $existImageIds = [], array $uploads = [], array $downloads = [])
    {
        $imagesCollection = $product->images()->get()->keyBy('id');

        foreach (array_values($existImageIds) as $sort => $imageId) {
            $imagesCollection->get($imageId)->fill(['sort' => $sort])->saveOrFail();
        }

        $imagesCollection->whereNotIn('id', $existImageIds)->map(function (Image $image) {
            $image->delete();
        });

        if (!empty($uploads)) {
            $this->addImages($product, $uploads, $sort ?? 0);
        }

        if (!empty($downloads)) {
            $this->addImages($product, $downloads, $sort ?? 0);
        }
    }

    /**
     * Добавить изображения.
     *
     * @param Product $product
     * @param array $images
     * @param int $sort
     */
    public function addImages(Product $product, array $images, $sort = 0)
    {
        foreach ($images as $index => $file) {
            $product->images()->create(['file' => $file, 'sort' => $sort + $index]);
        }
    }
}
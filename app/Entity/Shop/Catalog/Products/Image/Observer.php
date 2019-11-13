<?php

namespace App\Entity\Shop\Catalog\Products\Image;

use App\Helpers\ImageHelper;
use App\Repositories\Shop\Catalog\Product\ProductImageRepository;
use App\Repositories\Shop\Catalog\ProductRepository;
use Illuminate\Http\UploadedFile;

class Observer
{
    /**
     * @var ImageHelper
     */
    private $images;

    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * Observer constructor.
     * @param ImageHelper $imageHelper
     * @param ProductRepository $products
     */
    public function __construct(ImageHelper $imageHelper, ProductRepository $products)
    {
        $this->images   = $imageHelper;
        $this->products = $products;
    }

    /**
     * @param Image $image
     */
    public function creating(Image $image)
    {
        if ($image->file instanceof UploadedFile) {
            $image->file = $this->storeFile($image->file);
        }
    }

    /**
     * @param Image $image
     */
    public function deleted(Image $image)
    {
        $this->removeFile($image->file);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function storeFile(UploadedFile $file): string
    {
        return $this->images->storeUploadedFile('local', 'products', $file);
    }

    /**
     * @param string $file
     */
    private function removeFile(string $file)
    {
        if (!$this->products->existsByImageFile($file)) {
            $this->images->removeOriginal('local', 'products', $file);
            $this->images->removeResized('public', 'products', $file);
        }
    }
}

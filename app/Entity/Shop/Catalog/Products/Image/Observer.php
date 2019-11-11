<?php

namespace App\Entity\Shop\Catalog\Products\Image;

use App\Helpers\ImageHelper;
use App\Repositories\Shop\Catalog\Product\ProductImageRepository;
use Illuminate\Http\UploadedFile;

class Observer
{
    /**
     * @var ImageHelper
     */
    private $images;

    /**
     * @var ProductImageRepository
     */
    private $productImageRepository;

    /**
     * ImageObserver constructor.
     *
     * @param ImageHelper $imageHelper
     * @param ProductImageRepository $productImageRepository
     */
    public function __construct(ImageHelper $imageHelper, ProductImageRepository $productImageRepository)
    {
        $this->images                 = $imageHelper;
        $this->productImageRepository = $productImageRepository;
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
        if (!$this->productImageRepository->existsByFile($file)) {
            $this->images->removeOriginal('local', 'products', $file);
            $this->images->removeResized('public', 'products', $file);
        }
    }
}

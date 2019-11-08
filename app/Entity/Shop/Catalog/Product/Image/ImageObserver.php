<?php

namespace App\Entity\Shop\Catalog\Product\Image;

use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;

class ImageObserver
{
    /**
     * @var ImageHelper
     */
    private $images;

    /**
     * ImageObserver constructor.
     *
     * @param ImageHelper $imageHelper
     */
    public function __construct(ImageHelper $imageHelper)
    {
        $this->images = $imageHelper;
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
    public function deleting(Image $image)
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
        $this->images->removeOriginal('local', 'products', $file);
        $this->images->removeResized('public', 'products', $file);
    }
}

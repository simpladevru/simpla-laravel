<?php

namespace App\Entity\Shop\Brand;

use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;
use App\Entity\Shop\Catalog\Brand;

class BrandObserver
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
     * @param Brand $brand
     */
    public function saving(Brand $brand)
    {
        if ($brand->image instanceof UploadedFile) {
            if ($oldImage = $brand->getOriginal('image')) {
                $this->removeFile($oldImage);
            }
            $brand->image = $this->storeFile($brand->image);
        }

        if ($brand->slug == '') {
            $brand->slug = Str::slug($brand->name);
        }
    }

    /**
     * @param Brand $brand
     */
    public function deleted(Brand $brand)
    {
        if ($brand->image) {
            $this->removeFile($brand->image);
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function storeFile(UploadedFile $file): string
    {
        return $this->images->storeUploadedFile('local', 'brands', $file);
    }

    /**
     * @param string $file
     */
    private function removeFile(string $file)
    {
        $this->images->removeOriginal('local', 'brands', $file);
        $this->images->removeResized('public', 'brands', $file);
    }
}

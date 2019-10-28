<?php

namespace App\Entity\Shop\Catalog\Category;

use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CategoryObserver
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
     * @param Category $category
     */
    public function saving(Category $category)
    {
        if ($category->image instanceof UploadedFile) {
            if ($oldImage = $category->getOriginal('image')) {
                $this->removeFile($oldImage);
            }
            $category->image = $this->storeFile($category->image);
        }

        if ($category->slug == '') {
            $category->slug = Str::slug($category->name);
        }
    }

    /**
     * @param Category $category
     */
    public function deleted(Category $category)
    {
        $this->removeFile($category->image);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function storeFile(UploadedFile $file): string
    {
        return $this->images->storeUploadedFile('local', 'categories', $file);
    }

    /**
     * @param string $file
     */
    private function removeFile(string $file)
    {
        $this->images->removeOriginal('local', 'categories', $file);
        $this->images->removeResized('public', 'categories', $file);
    }
}
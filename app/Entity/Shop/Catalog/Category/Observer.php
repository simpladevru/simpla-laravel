<?php

namespace App\Entity\Shop\Catalog\Category;

use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Observer
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
        if (($oldImage = $category->getOriginal('image')) && $oldImage !== $category->image) {
            $this->removeFile($oldImage);
        }

        if ($category->image instanceof UploadedFile) {
            $category->image = $this->storeFile($category->image);
        }

        if ($category->slug == '') {
            $category->slug = Str::slug($category->name);
        }
    }

    /**
     * @param Category $category
     */
    public function deleting(Category $category)
    {
        if ($category->image) {
            $this->removeFile($category->image);
        }

        $category->getDescendants()->map(function (Category $descendant) {
            $descendant->delete();
        });
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

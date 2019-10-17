<?php

namespace App\Entity\Shop\Product\Image;

use Illuminate\Http\UploadedFile;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * @var FileHelper
     */
    private $fileHelper;

    /**
     * ImageObserver constructor.
     * @param FileHelper $fileHelper
     */
    public function __construct(FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
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
        return $this->fileHelper->storeUploadedFile('local', 'products', $file);
    }

    /**
     * @param string $file
     */
    private function removeFile(string $file)
    {
        Storage::disk('local')->delete('products/' . $file);

        $path      = Storage::disk('public')->path('products/');
        $filename  = pathinfo($file, PATHINFO_FILENAME);
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        File::delete(
            File::glob($path . $filename . '.*x*.' . $extension)
        );
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ResizeImageController extends Controller
{
    const DIRECTORY_PRODUCTS = 'products';

    private static $directories = [
        self::DIRECTORY_PRODUCTS,
    ];

    /**
     * @param $directory
     * @param $filename
     * @param $width
     * @param $height
     * @param $extension
     * @return mixed
     * @throws Exception
     */
    public function resize($directory, $filename, $width, $height, $extension)
    {
        if (!in_array($directory, static::$directories)) {
            throw new Exception('Directory not found');
        }

        $originalImage = Storage::disk('local')->path('products/' . $filename . '.' . $extension);

        if (!file_exists($originalImage)) {
            throw new Exception('File not found');
        }

        $resizedPath = Storage::disk('public')->path($directory . '/');

        if (!File::isDirectory($resizedPath)) {
            File::makeDirectory($resizedPath, 0755, true);
        }

        $newImage   = Image::make($originalImage);
        $resizeName = $newImage->filename . '.' . $width . 'x' . $height . '.' . $newImage->extension;

        $newImage->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->save($resizedPath . $resizeName);

        return $newImage->response();
    }
}

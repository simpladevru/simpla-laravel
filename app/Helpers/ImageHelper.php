<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ImageFactory;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * @param $originalDisk
     * @param $resizedDisk
     * @param $directory
     * @param $filename
     * @param $width
     * @param $height
     * @param $extension
     * @return Image
     * @throws Exception
     */
    public function resize($originalDisk, $resizedDisk, $directory, $filename, $width, $height, $extension): Image
    {
        $originalImage = Storage::disk($originalDisk)->path($directory . '/' . $filename . '.' . $extension);

        if (!file_exists($originalImage)) {
            throw new Exception('File not found');
        }

        $resizedPath = Storage::disk($resizedDisk)->path($directory . '/');

        if (!File::isDirectory($resizedPath)) {
            File::makeDirectory($resizedPath, 0755, true);
        }

        $newImage   = ImageFactory::make($originalImage);
        $resizeName = $newImage->filename . '.' . $width . 'x' . $height . '.' . $newImage->extension;

        $newImage->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->save($resizedPath . $resizeName);

        return $newImage;
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param UploadedFile $file
     * @return string
     */
    public function storeUploadedFile(string $disk, string $directory, UploadedFile $file): string
    {
        $name      = $this->getPrepareUploadedFilename($file);
        $extension = $file->getClientOriginalExtension();

        $filename = $this->getUniqueFilename($disk, $directory, $name, $extension);

        $file->storeAs($directory, $filename, $disk);

        return $filename;
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @param string $extension
     * @return string
     */
    public function getUniqueFilename(string $disk, string $directory, string $name, string $extension): string
    {
        $storage = Storage::disk($disk);

        $filename   = $name . '.' . $extension;
        $uniqueName = $name;

        while ($storage->exists($directory . '/' . $filename)) {
            if (preg_match('/-([0-9]+)$/', $uniqueName, $parts)) {
                $uniqueName = $name . '-' . ($parts[1] + 1);
            } else {
                $uniqueName = $name . '-1';
            }
            $filename = $uniqueName . '.' . $extension;
        }

        return $filename;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function getPrepareUploadedFilename(UploadedFile $file): string
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    }

    /**
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedFilename(string $filename, $width = 0, $height = 0, $set_watermark = false)
    {
        $file = pathinfo($filename, PATHINFO_FILENAME);
        $ext  = pathinfo($filename, PATHINFO_EXTENSION);

        if ($width > 0 || $height > 0) {
            $resizedFilename = $file . '.' . ($width > 0 ? $width : '') . 'x' . ($height > 0 ? $height : '') . ($set_watermark ? 'w' : '') . '.' . $ext;
        } else {
            $resizedFilename = $file . '.' . ($set_watermark ? 'w.' : '') . $ext;
        }

        return $resizedFilename;
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param string $file
     */
    public function removeOriginal(string $disk, string $directory, string $file)
    {
        Storage::disk($disk)->delete($directory . '/' . $file);
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param string $file
     */
    public function removeResized(string $disk, string $directory, string $file)
    {
        $path = Storage::disk($disk)->path($directory . '/');

        $filename  = pathinfo($file, PATHINFO_FILENAME);
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        File::delete(
            File::glob($path . $filename . '.*x*.' . $extension)
        );
    }
}

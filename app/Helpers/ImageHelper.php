<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * @param string $disk
     * @param string $directory
     * @param UploadedFile $file
     * @return string
     */
    public function storeUploadedFile(string $disk, string $directory, UploadedFile $file): string
    {
        $storage = Storage::disk($disk);

        $name      = $this->getPrepareUploadedFilename($file);
        $extension = $file->getClientOriginalExtension();

        $filename = $this->getUniqueFilename($storage, $directory, $name, $extension);

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

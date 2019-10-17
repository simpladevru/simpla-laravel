<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class FileHelper
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

        $name      = $this->getPrepareFilename($file);
        $extension = $file->getClientOriginalExtension();

        $filename = $this->getUniqueFilename($storage, $directory, $name, $extension);

        $file->storeAs($directory, $filename, $disk);

        return $filename;
    }

    /**
     * @param FilesystemAdapter $storage
     * @param string $directory
     * @param string $name
     * @param string $extension
     * @return string
     */
    public function getUniqueFilename(
        FilesystemAdapter $storage,
        string $directory,
        string $name,
        string $extension
    ): string {
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
    private function getPrepareFilename(UploadedFile $file): string
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    }
}
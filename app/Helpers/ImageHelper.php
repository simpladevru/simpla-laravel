<?php

namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageFactory;

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

        return $newImage->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->save($resizedPath . $resizeName);
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param string $url
     * @return string
     * @throws Exception
     */
    public function storeFileByUrl(string $disk, string $directory, string $url): string
    {
        $response = (new Client)->get($url);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Error status');
        }

        if (!$response->getHeaderLine('Content-Length')) {
            throw new Exception('Error size');
        }

        $filename  = $this->getPreparedFilename($url);
        $extension = $this->getExtensionByMime($response->getHeaderLine('Content-Type'));

        $newFilename = $filename . '.' . $extension;

        Storage::disk($disk)->put($directory . '/' . $newFilename, $response->getBody()->getContents());

        return $newFilename;
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param UploadedFile $file
     * @return string
     */
    public function storeUploadedFile(string $disk, string $directory, UploadedFile $file): string
    {
        $name      = $this->getPreparedUploadFilename($file);
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
    public function getPreparedUploadFilename(UploadedFile $file): string
    {
        return $this->getPreparedFilename($file->getClientOriginalName());
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getPreparedFilename(string $filename): string
    {
        return Str::slug(pathinfo($filename, PATHINFO_FILENAME));
    }

    /**
     * @param string $disk
     * @param string $directory
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedUrl(
        string $disk,
        string $directory,
        string $filename,
        int $width = 0,
        int $height = 0,
        bool $set_watermark = false
    ) {
        return Storage::disk($disk)->url($directory . '/')
            . $this->getResizedFilename($filename, $width, $height, $set_watermark);
    }

    /**
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedFilename(string $filename, int $width = 0, int $height = 0, bool $set_watermark = false)
    {
        if ('.' != ($dirname = pathinfo($filename, PATHINFO_DIRNAME))) {
            $file = $dirname . '/' . pathinfo($filename, PATHINFO_FILENAME);
        } else {
            $file = pathinfo($filename, PATHINFO_FILENAME);
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if ($width > 0 || $height > 0) {
            $file_width     = $width > 0 ? $width : '';
            $file_height    = $height > 0 ? $height : '';
            $file_watermark = ($set_watermark ? 'w' : '');

            $resizedFilename = $file . '.' . $file_width . 'x' . $file_height . $file_watermark . '.' . $extension;
        } else {
            $resizedFilename = $file . '.' . ($set_watermark ? 'w.' : '') . $extension;
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

    /**
     * @param $mime
     * @return string
     * @throws Exception
     */
    private function getExtensionByMime($mime): string
    {
        switch ($mime) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/gif':
                $ext = 'gif';
                break;
            default:
                throw new Exception('Undefined extension for mime: ' . $mime);
                break;
        }

        return $ext;
    }
}

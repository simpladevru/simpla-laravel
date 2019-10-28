<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ImageHelper;
use App\Entity\Shop\Catalog\Product\Image\DownloadHandler as ProductDownloadHandler;

class ResizeImageController extends Controller
{
    const DIRECTORY_PRODUCTS = 'products';

    private static $directories = [
        self::DIRECTORY_PRODUCTS,
    ];

    /**
     * @var ImageHelper
     */
    private $images;

    /**
     * ResizeImageController constructor.
     *
     * @param ImageHelper $images
     */
    public function __construct(ImageHelper $images)
    {
        $this->images = $images;
    }

    /**
     * @return array
     */
    private function downloadHandlers()
    {
        return [
            self::DIRECTORY_PRODUCTS => ProductDownloadHandler::class,
        ];
    }

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

        if (substr($filename, 0, 7) == 'http://') {
            $handlerClass = $this->downloadHandlers()[$directory];
            $filename     = $this->images->downloadFile('local', $directory, $filename, $handlerClass);
        }

        $newImage = $this->images->resize(
            'local',
            'public',
            $directory,
            $filename,
            $width,
            $height,
            $extension
        );

        return $newImage->response();
    }
}

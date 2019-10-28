<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ImageHelper;
use App\Entity\Shop\Product\Image\Image as ProductImage;

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
            self::DIRECTORY_PRODUCTS => function (string $oldFilename, string $newFilename) {
                throw new Exception(ProductImage::class);
            },
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
            $filename = $this->images->downloadFile($filename);
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

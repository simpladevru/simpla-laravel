<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ImageHelper;
use Intervention\Image\Image;

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

        /** @var Image $newImage */
        $newImage = $this->images->resize(
            'local',
            'public',
            'products',
            $filename,
            $width,
            $height,
            $extension
        );

        return $newImage->response();
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ImageHelper;

class ResizeImageController extends Controller
{
    const DIRECTORY_BRANDS     = 'brands';
    const DIRECTORY_PRODUCTS   = 'products';
    const DIRECTORY_CATEGORIES = 'categories';

    private static $directories = [
        self::DIRECTORY_BRANDS,
        self::DIRECTORY_PRODUCTS,
        self::DIRECTORY_CATEGORIES,
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

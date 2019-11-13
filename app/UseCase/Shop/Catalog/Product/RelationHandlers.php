<?php

namespace App\UseCase\Shop\Catalog\Product;

use App\UseCase\Shop\Catalog\Product\Handlers\ImagesHandler;
use App\UseCase\Shop\Catalog\Product\Handlers\VariantsHandler;
use App\UseCase\Shop\Catalog\Product\Handlers\CategoriesHandler;
use App\UseCase\Shop\Catalog\Product\Handlers\AttributesHandler;

class RelationHandlers
{
    /**
     * @var VariantsHandler
     */
    public $variants;
    /**
     * @var ImagesHandler
     */
    public $images;
    /**
     * @var CategoriesHandler
     */
    public $categories;
    /**
     * @var AttributesHandler
     */
    public $attributes;

    /**
     * Relations constructor.
     * @param VariantsHandler $variantsHandler
     * @param ImagesHandler $imagesHandler
     * @param CategoriesHandler $categoriesHandler
     * @param AttributesHandler $attributesHandler
     */
    public function __construct(
        VariantsHandler $variantsHandler,
        ImagesHandler $imagesHandler,
        CategoriesHandler $categoriesHandler,
        AttributesHandler $attributesHandler
    ) {
        $this->variants   = $variantsHandler;
        $this->images     = $imagesHandler;
        $this->categories = $categoriesHandler;
        $this->attributes = $attributesHandler;
    }
}
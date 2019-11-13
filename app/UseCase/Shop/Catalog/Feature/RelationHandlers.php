<?php

namespace App\UseCase\Shop\Catalog\Feature;

use App\UseCase\Shop\Catalog\Feature\Handlers\CategoriesHandler;

class RelationHandlers
{
    /**
     * @var CategoriesHandler
     */
    public $categories;

    /**
     * RelationHandlers constructor.
     * @param CategoriesHandler $categories
     */
    public function __construct(CategoriesHandler $categories)
    {
        $this->categories = $categories;
    }
}
<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use App\Entity\Shop\Catalog\Category;
use App\Repositories\Shop\Catalog\CategoryRepository;
use App\Http\Requests\Admin\Shop\Catalog\CategoryRequest;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CategoryRequest $request
     * @return Category
     */
    public function create(CategoryRequest $request): Category
    {
        $category = Category::create([
            'name'             => $request['name'],
            'slug'             => $request['slug'],
            'description'      => $request['description'],
            'meta_title'       => $request['meta_title'],
            'meta_keywords'    => $request['meta_keywords'],
            'meta_description' => $request['meta_description'],
        ]);

        return $category;
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @return Category
     */
    public function edit(int $id, CategoryRequest $request): Category
    {
        $category = $this->repository->getOne($id);

        $category->update([
            'name'             => $request['name'],
            'slug'             => $request['slug'],
            'description'      => $request['description'],
            'meta_title'       => $request['meta_title'],
            'meta_keywords'    => $request['meta_keywords'],
            'meta_description' => $request['meta_description'],
        ]);

        return $category;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->repository->getOne($id)->delete();
    }
}

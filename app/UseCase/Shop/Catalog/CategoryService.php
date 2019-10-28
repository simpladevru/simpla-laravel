<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use App\Entity\Shop\Catalog\Category\Category;
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
        $data = $request->validated();

        $category = Category::create([
            'name'             => $data['name'],
            'slug'             => $data['slug'],
            'image'            => $data['image'],
            'description'      => $data['description'],
            'meta_title'       => $data['meta_title'],
            'meta_keywords'    => $data['meta_keywords'],
            'meta_description' => $data['meta_description'],
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
        $data     = $request->validated();

        $category->update([
            'name'             => $data['name'],
            'slug'             => $data['slug'],
            'image'            => $data['image'],
            'description'      => $data['description'],
            'meta_title'       => $data['meta_title'],
            'meta_keywords'    => $data['meta_keywords'],
            'meta_description' => $data['meta_description'],
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

<?php

namespace App\UseCase\Admin;

use Exception;
use App\Entity\Shop\Catalog\Category\Category;
use App\Repositories\Shop\Catalog\CategoryRepository;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $attributes
     * @return Category
     */
    public function create(array $attributes): Category
    {
        return Category::create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Category
     */
    public function update(int $id, array $attributes): Category
    {
        $category = $this->repository->getOne($id);
        $category->update($attributes);

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

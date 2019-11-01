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
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Создать категорию.
     *
     * @param array $attributes
     * @return Category
     */
    public function create(array $attributes): Category
    {
        return Category::create($attributes);
    }

    /**
     * Обновить категорию.
     *
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
     * Удалить категорию.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->repository->getOne($id)->delete();
    }
}

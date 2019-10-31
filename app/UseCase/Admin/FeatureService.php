<?php

namespace App\UseCase\Admin;

use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
use App\Entity\Shop\Feature\Feature;
use App\Repositories\Shop\Catalog\FeatureRepository;

class FeatureService
{
    /**
     * @var FeatureRepository
     */
    private $repository;

    /**
     * FeatureService constructor.
     * @param FeatureRepository $repository
     */
    public function __construct(FeatureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $attributes
     * @return Feature
     */
    public function create(array $attributes): Feature
    {
        return Feature::create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Feature
     */
    public function update(int $id, array $attributes): Feature
    {
        $feature = $this->repository->getOne($id);
        $feature->update($attributes);

        return $feature;
    }

    /**
     * @param array $attributes
     * @return Feature
     * @throws Throwable
     */
    public function createWithRelations(array $attributes): Feature
    {
        return DB::transaction(function () use ($attributes) {
            $feature = $this->create($attributes);
            $this->updateRelations($feature, $attributes);
            return $feature;
        });
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Feature
     * @throws Throwable
     */
    public function updateWithRelations(int $id, array $attributes): Feature
    {
        return DB::transaction(function () use ($id, $attributes) {
            $feature = $this->update($id, $attributes);
            $this->updateRelations($feature, $attributes);
            return $feature;
        });
    }

    /**
     * @param Feature $feature
     * @param array $data
     * @throws Throwable
     */
    public function updateRelations(Feature $feature, array $data = []): void
    {
        DB::transaction(function () use ($feature, $data) {
            $this->updateCategories($feature, $data['category_ids']);
        });
    }

    /**
     * @param Feature $feature
     * @param array $categoryIds
     */
    public function updateCategories(Feature $feature, array $categoryIds = []): void
    {
        $feature->categories()->detach();

        foreach ($categoryIds as $categoryId) {
            $feature->addToCategory($categoryId);
        }
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

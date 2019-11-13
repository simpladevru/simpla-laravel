<?php

namespace App\UseCase\Shop\Catalog\Feature;

use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
use App\Entity\Shop\Catalog\Feature\Feature;
use App\Repositories\Shop\Catalog\FeatureRepository;

class FeatureService
{
    /**
     * @var FeatureRepository
     */
    private $features;

    /**
     * FeatureService constructor.
     * @param FeatureRepository $features
     */
    public function __construct(FeatureRepository $features)
    {
        $this->features = $features;
    }

    /**
     * Создать свойство.
     *
     * @param array $attributes
     * @return Feature
     */
    public function create(array $attributes): Feature
    {
        return Feature::create($attributes);
    }

    /**
     * Обновить свойсто.
     *
     * @param int $id
     * @param array $attributes
     * @return Feature
     */
    public function update(int $id, array $attributes): Feature
    {
        $feature = $this->features->getOne($id);
        $feature->update($attributes);

        return $feature;
    }

    /**
     * Создать свойство со связями.
     *
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
     * Обновить свойство со связями.
     *
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
     * Обновить связи свойства.
     *
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
     * Обновить список категорий в которых используется свойство.
     *
     * @param Feature $feature
     * @param array $categoryIds
     */
    public function updateCategories(Feature $feature, array $categoryIds = []): void
    {
        $feature->categories()->detach();

        foreach ($categoryIds as $categoryId) {
            $feature->categories()->attach($categoryId);
        }
    }

    /**
     * Удалить свойство.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->features->getOne($id)->delete();
    }
}

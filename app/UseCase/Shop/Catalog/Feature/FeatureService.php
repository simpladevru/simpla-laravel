<?php

namespace App\UseCase\Shop\Catalog\Feature;

use Exception;
use Throwable;
use App\Entity\Shop\Catalog\Feature\Feature;
use App\Repositories\Shop\Catalog\FeatureRepository;

class FeatureService
{
    /**
     * @var FeatureRepository
     */
    private $features;
    /**
     * @var RelationHandlers
     */
    private $relations;

    /**
     * FeatureService constructor.
     * @param FeatureRepository $features
     * @param RelationHandlers $relations
     */
    public function __construct(FeatureRepository $features, RelationHandlers $relations)
    {
        $this->features  = $features;
        $this->relations = $relations;
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
        $feature = $this->create($attributes);

        $this->updateRelations($feature, $attributes);

        return $feature;
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
        $feature = $this->update($id, $attributes);

        $this->updateRelations($feature, $attributes);

        return $feature;
    }

    /**
     * @param Feature $feature
     * @param array $data
     * @throws Throwable
     */
    public function updateRelations(Feature $feature, array $data = []): void
    {
        $this->relations->categories->update($feature, $data['category_ids']);
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

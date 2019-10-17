<?php

namespace App\UseCase\Shop\Catalog;

use Exception;
use Illuminate\Support\Arr;
use App\Entity\Shop\Feature;
use App\Repositories\Shop\Catalog\FeatureRepository;

class FeatureService
{
    /**
     * @var FeatureRepository
     */
    private $repository;

    /**
     * FeatureService constructor.
     *
     * @param FeatureRepository $repository
     */
    public function __construct(FeatureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return Feature
     */
    public function create(array $data): Feature
    {
        return $this->fillAndSave(new Feature(), $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Feature
     */
    public function edit(int $id, array $data): Feature
    {
        return $this->fillAndSave($this->repository->getOne($id), $data);
    }

    /**
     * @param Feature $feature
     * @param array $data
     * @return Feature
     */
    public function fillAndSave(Feature $feature, array $data): Feature
    {
        $feature->fill(Arr::only($data, [
            'name',
        ]))->save();

        return $feature;
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

<?php

namespace App\UseCase\Admin;

use Exception;
use ReflectionException;
use App\Helpers\Dto;
use App\Entity\Shop\Feature\Feature;
use App\Entity\Shop\Catalog\Feature\FeatureDto;
use App\Repositories\Shop\Catalog\FeatureRepository;
use App\Http\Requests\Admin\Shop\Catalog\FeatureRequest;

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
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->repository->getOne($id)->delete();
    }
}

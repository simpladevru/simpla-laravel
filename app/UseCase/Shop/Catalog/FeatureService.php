<?php

namespace App\UseCase\Shop\Catalog;

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
     *
     * @param FeatureRepository $repository
     */
    public function __construct(FeatureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FeatureRequest $request
     * @return Feature
     * @throws ReflectionException
     */
    public function create(FeatureRequest $request): Feature
    {
        $dto = Dto::make($request->validated(), FeatureDto::class);
        return $this->fillAndSave(new Feature(), $dto);
    }

    /**
     * @param int $id
     * @param FeatureRequest $request
     * @return Feature
     * @throws ReflectionException
     */
    public function edit(int $id, FeatureRequest $request): Feature
    {
        $dto = Dto::make($request->validated(), FeatureDto::class);
        return $this->fillAndSave($this->repository->getOne($id), $dto);
    }

    /**
     * @param Feature $feature
     * @param FeatureDto $dto
     * @return Feature
     */
    public function fillAndSave(Feature $feature, FeatureDto $dto): Feature
    {
        $feature->fill([
            'name' => $dto->name
        ])->save();

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

<?php

namespace App\UseCase\Admin;

use Throwable;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Entity\Shop\Product\Product;
use App\Entity\Shop\Product\Variant;
use App\Entity\Shop\Product\Attribute;
use App\Entity\Shop\Product\Image\Image;
use App\Repositories\Shop\Catalog\ProductRepository;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @var VariantService
     */
    private $variantService;

    /**
     * ProductService constructor.
     * @param ProductRepository $repository
     * @param VariantService $variantService
     */
    public function __construct(ProductRepository $repository, VariantService $variantService)
    {
        $this->repository     = $repository;
        $this->variantService = $variantService;
    }

    /**
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product
    {
        return Product::create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Product
     */
    public function update(int $id, array $attributes): Product
    {
        $product = $this->repository->getOne($id);
        $product->update($attributes);

        return $product;
    }

    /**
     * @param array $attributes
     * @return Product
     * @throws Throwable
     */
    public function createWithRelations(array $attributes): Product
    {
        return DB::transaction(function () use ($attributes) {
            $product = $this->create($attributes);
            $this->updateRelations($product, $attributes);
            return $product;
        });
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Product
     * @throws Throwable
     */
    public function updateWithRelations(int $id, array $attributes): Product
    {
        return DB::transaction(function () use ($id, $attributes) {
            $product = $this->update($id, $attributes);
            $this->updateRelations($product, $attributes);
            return $product;
        });
    }

    /**
     * @param Product $product
     * @param array $data
     * @throws Throwable
     */
    private function updateRelations(Product $product, array $data = []): void
    {
        $this->updateVariants($product, $data['variants']);
        $this->updateAttributes($product, $data['attributes']);
        $this->updateImages($product, $data['images'], $data['upload_images']);
    }

    /**
     * @param Product $product
     * @param array $variants
     * @throws Throwable
     */
    private function updateVariants(Product $product, array $variants = []): void
    {
        $variantsRelation   = $product->variants();
        $variantsCollection = $variantsRelation->get()->keyBy('id');

        $existIds = [];

        foreach (array_values($variants) as $sort => $data) {
            $existIds[] = $data['id'];

            $this->variantService->fillAndSave(
                $variantsCollection->get($data['id'], $variantsRelation->make()),
                array_merge($data, ['sort' => $sort])
            );
        }

        $variantsCollection->whereNotIn('id', array_filter($existIds))->map(function (Variant $variant) {
            $variant->delete();
        });
    }

    /**
     * @param Product $product
     * @param array $attributes
     */
    private function updateAttributes(Product $product, array $attributes = []): void
    {
        $attributesRelation   = $product->attributes();
        $attributesCollection = $attributesRelation->get()->keyBy('id');

        $existIds = [];

        foreach ($attributes as $featureId => $values) {
            foreach ($values as $value) {
                if ($value['value']) {
                    $existIds[] = $value['id'];

                    $attribute = $attributesCollection->get($value['id'], $attributesRelation->make());

                    $attribute->fill([
                        'feature_id' => $featureId,
                        'value'      => $value['value'] ?? '',
                    ])->saveOrFail();
                }
            }
        }

        $attributesCollection->whereNotIn('id', array_filter($existIds))->map(function (Attribute $attribute) {
            $attribute->delete();
        });
    }

    /**
     * @param Product $product
     * @param array $images
     * @param array $uploads
     * @param array $downloads
     */
    private function updateImages(Product $product, array $images = [], array $uploads = [], array $downloads = [])
    {
        $imagesCollection = $product->images()->get()->keyBy('id');

        foreach (array_values($images) as $sort => $imageId) {
            $imagesCollection->get($imageId)->fill(['sort' => $sort])->saveOrFail();
        }

        $imagesCollection->whereNotIn('id', $images)->map(function (Image $image) {
            $image->delete();
        });

        if (!empty($uploads)) {
            $this->addImages($product, $uploads, $sort ?? 0);
        }

        if (!empty($downloads)) {
            $this->addImages($product, $downloads, $sort ?? 0);
        }
    }

    /**
     * @param Product $product
     * @param array $images
     * @param int $sort
     */
    public function addImages(Product $product, array $images, $sort = 0)
    {
        foreach ($images as $index => $file) {
            $product->images()->create(['file' => $file, 'sort' => $sort + $index]);
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

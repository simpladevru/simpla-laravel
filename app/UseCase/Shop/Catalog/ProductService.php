<?php

namespace App\UseCase\Shop\Catalog;

use App\UseCase\Admin\VariantService;
use Throwable;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Entity\Shop\Product\Product;
use App\Entity\Shop\Product\Variant;
use App\Entity\Shop\Product\Attribute;
use App\Entity\Shop\Product\Image\Image;
use App\Repositories\Shop\Catalog\ProductRepository;
use App\Http\Requests\Admin\Shop\Catalog\ProductRequest;

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
     *
     * @param ProductRepository $repository
     * @param VariantService $variantService
     */
    public function __construct(ProductRepository $repository, VariantService $variantService)
    {
        $this->repository     = $repository;
        $this->variantService = $variantService;
    }

    /**
     * @param ProductRequest $request
     * @return Product
     * @throws Throwable
     */
    public function createByRequest(ProductRequest $request): Product
    {
        return $this->fillAndSave(new Product(), $request->validated());
    }

    /**
     * @param int $id
     * @param ProductRequest $request
     * @return Product
     * @throws Throwable
     */
    public function editByRequest(int $id, ProductRequest $request): Product
    {
        return $this->fillAndSave($this->repository->getOne($id), $request->validated());
    }

    /**
     * @param Product $product
     * @param array $data
     * @return Product
     * @throws Throwable
     */
    private function fillAndSave(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->fill(Arr::only($data, [
                'name',
                'slug',
                'brand_id',
                'is_active',
                'is_featured',
                'annotation',
                'description',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'sort',
            ]))->saveOrFail();

            $this->updateParts($product, $data);

            return $product;
        });
    }

    /**
     * @param Product $product
     * @param array $data
     * @throws Throwable
     */
    private function updateParts(Product $product, array $data = []): void
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
            $sort = $sort ?? 0;
            foreach ($uploads as $index => $file) {
                $product->images()->create(['file' => $file, 'sort' => $sort + $index]);
            }
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

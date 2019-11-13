<?php

namespace App\UseCase\Shop\Catalog\Product;

use Throwable;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Entity\Shop\Catalog\Products\Image\Image;
use App\UseCase\Shop\Catalog\Variant\VariantService;
use App\Entity\Shop\Catalog\Products\Variant\Variant;
use App\Entity\Shop\Catalog\Products\Product\Product;
use App\Entity\Shop\Catalog\Products\Attribute\Attribute;
use App\Repositories\Shop\Catalog\ProductRepository;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * @var VariantService
     */
    private $variantService;

    /**
     * @param ProductRepository $repository
     * @param VariantService $variantService
     */
    public function __construct(ProductRepository $repository, VariantService $variantService)
    {
        $this->products       = $repository;
        $this->variantService = $variantService;
    }

    /**
     * Создать товар.
     *
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product
    {
        return Product::create($attributes);
    }

    /**
     * Обновить товар.
     *
     * @param int $id
     * @param array $attributes
     * @return Product
     */
    public function update(int $id, array $attributes): Product
    {
        $product = $this->products->getOne($id);
        $product->update($attributes);

        return $product;
    }

    /**
     * Копировать товар.
     *
     * @param int $id
     * @throws Throwable
     */
    public function copy(int $id)
    {
        $product = $this->products->getOne($id)->load([
            'categoryPivot',
            'variants',
            'attributes',
            'images',
        ]);

        DB::transaction(function () use ($product) {
            $clone = $product->replicate();
            $clone->save();

            foreach ($product->getRelations() as $relationName => $relation) {
                $clone->{$relationName}()->createMany($relation->toArray());
            }
        });
    }

    /**
     * Создать товар со связями.
     *
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
     * Обновить товар со связями.
     *
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
     * Обновить связи товара.
     *
     * @param Product $product
     * @param array $data
     * @throws Throwable
     */
    public function updateRelations(Product $product, array $data = []): void
    {
        DB::transaction(function () use ($product, $data) {
            $this->updateCategories($product, $data['category_ids']);
            $this->updateVariants($product, $data['variants']);
            $this->updateAttributesGroupedByFeatureId($product, $data['attributes']);
            $this->updateImages($product, $data['exist_image_ids'], $data['upload_images']);
        });
    }

    /**
     * Обновить список категорий в которых присутствует товар.
     *
     * @param Product $product
     * @param array $categoryIds
     */
    public function updateCategories(Product $product, array $categoryIds = []): void
    {
        $product->categories()->detach();

        foreach ($categoryIds as $index => $categoryId) {
            $product->categories()->attach($categoryId, ['sort' => $index]);
        }
    }

    /**
     * Обновить варианты.
     *
     * @param Product $product
     * @param array $variants
     * @throws Throwable
     */
    public function updateVariants(Product $product, array $variants = []): void
    {
        $variantsRelation   = $product->variants();
        $variantsCollection = $variantsRelation->get()->keyBy('id');

        $existIds = [];

        foreach (array_values($variants) as $sort => $data) {
            $variant = $variantsCollection->get($data['id'], $variantsRelation->make());
            $variant->fill(array_merge($data, ['sort' => $sort]))->save();

            $existIds[] = $data['id'];
        }

        $variantsCollection->whereNotIn('id', array_filter($existIds))->map(function (Variant $variant) {
            $variant->delete();
        });
    }

    /**
     * Обновить характеристики.
     *
     * @param Product $product
     * @param array $attributes
     */
    public function updateAttributesGroupedByFeatureId(Product $product, array $attributes = []): void
    {
        $attributesRelation   = $product->attributes();
        $attributesCollection = $attributesRelation->get()->keyBy('id');

        $existIds = [];

        foreach ($attributes as $featureId => $values) {
            foreach ($values as $value) {
                if ($value['value']) {
                    $attribute = $attributesCollection->get($value['id'], $attributesRelation->make());
                    $attribute->fill(['feature_id' => $featureId, 'value' => $value['value'] ?? ''])->saveOrFail();

                    $existIds[] = $value['id'];
                }
            }
        }

        $attributesCollection->whereNotIn('id', array_filter($existIds))->map(function (Attribute $attribute) {
            $attribute->delete();
        });
    }

    /**
     * Обновить изображения.
     *
     * @param Product $product
     * @param array $existImageIds
     * @param array $uploads
     * @param array $downloads
     */
    public function updateImages(
        Product $product,
        array $existImageIds = [],
        array $uploads = [],
        array $downloads = []
    ) {
        $imagesCollection = $product->images()->get()->keyBy('id');

        foreach (array_values($existImageIds) as $sort => $imageId) {
            $imagesCollection->get($imageId)->fill(['sort' => $sort])->saveOrFail();
        }

        $imagesCollection->whereNotIn('id', $existImageIds)->map(function (Image $image) {
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
     * Добавить изображения.
     *
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
     * Удалить товар.
     *
     * @param int $id
     * @throws Exception
     */
    public function remove(int $id)
    {
        $this->products->getOne($id)->delete();
    }
}

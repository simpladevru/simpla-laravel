<?php

namespace App\UseCase\Shop\Catalog\Product;

use Throwable;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\Shop\Catalog\ProductRepository;
use App\Entity\Shop\Catalog\Products\Product\Product;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var RelationService
     */
    private $relations;

    /**
     * ProductService constructor.
     * @param ProductRepository $products
     * @param RelationService $relations
     */
    public function __construct(ProductRepository $products, RelationService $relations)
    {
        $this->products  = $products;
        $this->relations = $relations;
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
        $product = $this->create($attributes);

        $this->updateRelations($product, $attributes);

        return $product;
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
        $product = $this->update($id, $attributes);

        $this->updateRelations($product, $attributes);

        return $product;
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
            $this->relations->categories->update($product, $data['category_ids']);
            $this->relations->variants->update($product, $data['variants']);
            $this->relations->attributes->updateGroupedByFeatureId($product, $data['attributes']);
            $this->relations->images->update($product, $data['exist_image_ids'], $data['upload_images']);
        });
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

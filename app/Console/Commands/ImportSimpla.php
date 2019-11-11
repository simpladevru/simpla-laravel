<?php

namespace App\Console\Commands;

use App\Entity\Shop\Catalog\Category\Category;
use App\Helpers\Tables;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportSimpla extends Command
{
    const DATABASE = 'simpla';

    protected $signature   = 'import:simpla';

    protected $description = 'import Simpls Cms';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->brands();
        $this->features();
        $this->categories();
        $this->categoryFeatures();
        $this->products();
        $this->variants();
        $this->images();
        $this->productCategories();
        $this->attributes();
    }

    public function brands()
    {
        DB::table(Tables::SHOP_BRANDS)->delete();

        DB::table(static::DATABASE . '.s_brands')->get()->map(function ($brand) {
            DB::table(Tables::SHOP_BRANDS)->insert([
                'id'    => $brand->id,
                'name'  => $brand->name,
                'slug'  => Str::slug($brand->name),
                'image' => $brand->image,
            ]);
        });
    }

    public function features()
    {
        DB::table(Tables::SHOP_FEATURES)->delete();

        DB::table(static::DATABASE . '.s_features')->get()->map(function ($feature) {
            DB::table(Tables::SHOP_FEATURES)->insert([
                'id'        => $feature->id,
                'name'      => $feature->name,
                'in_filter' => $feature->in_filter ? 1 : 0,
                'sort'      => $feature->position,
            ]);
        });
    }

    public function categories()
    {
        DB::table(Tables::SHOP_CATEGORIES)->delete();

        $categories = DB::table(static::DATABASE . '.s_categories')
            ->select(['id', 'name', 'image', 'parent_id'])
            ->orderBy('parent_id')
            ->orderBy('position')
            ->get()
            ->pluck(null, 'id');

        $addCategory = function ($category) use (&$addCategory, $categories) {
            $category->parent_id = $category->parent_id ?: null;

            if (
                $category->parent_id > 0
                && !DB::table(Tables::SHOP_CATEGORIES)->where('id', $category->parent_id)->exists()
            ) {
                $addCategory($categories->get($category->parent_id));
                $categories->forget($category->parent_id);
            }

            DB::table(Tables::SHOP_CATEGORIES)->insert([
                'id'        => $category->id,
                'name'      => $category->name,
                'image'     => $category->image,
                'parent_id' => $category->parent_id,
                'slug'      => Str::slug($category->name),
            ]);
        };

        foreach ($categories as $index => $category) {
            $addCategory($category);
            $categories->forget($category->parent_id);
        }

        Category::fixTree();
    }

    public function categoryFeatures()
    {
        DB::table(Tables::SHOP_CATEGORY_FEATURES)->delete();

        DB::table(static::DATABASE . '.s_categories_features')->get()->map(function ($relation) {
            if (
                !DB::table(Tables::SHOP_CATEGORIES)->where('id', $relation->category_id)->exists()
                || !DB::table(Tables::SHOP_FEATURES)->where('id', $relation->feature_id)->exists()
            ) {
                return;
            }

            DB::table(Tables::SHOP_CATEGORY_FEATURES)->insert([
                'category_id' => $relation->category_id,
                'feature_id'  => $relation->feature_id,
            ]);
        });
    }

    public function products()
    {
        DB::table(Tables::SHOP_PRODUCTS)->delete();

        DB::table(static::DATABASE . '.s_products')->get()->map(function ($product) {
            DB::table(Tables::SHOP_PRODUCTS)->insert([
                'id'       => $product->id,
                'name'     => $product->name,
                'slug'     => Str::slug($product->name),
                'brand_id' => $product->brand_id ?: null,
            ]);
        });
    }

    public function variants()
    {
        DB::table(Tables::SHOP_PRODUCT_VARIANTS)->delete();

        DB::table(static::DATABASE . '.s_variants')->get()->map(function ($variant) {
            if (!DB::table(Tables::SHOP_PRODUCTS)->where('id', $variant->product_id)->exists()) {
                return;
            }

            DB::table(Tables::SHOP_PRODUCT_VARIANTS)->insert([
                'id'            => $variant->id,
                'name'          => $variant->name,
                'product_id'    => $variant->product_id,
                'price'         => $variant->price > 0 ? $variant->price : 0,
                'compare_price' => $variant->compare_price ? $variant->compare_price : null,
                'sku'           => $variant->sku,
                'stock'         => $variant->stock,
                'sort'          => $variant->position,
            ]);
        });
    }

    public function images()
    {
        DB::table(Tables::SHOP_PRODUCT_IMAGES)->delete();

        DB::table(static::DATABASE . '.s_images')->get()->map(function ($image) {
            if (!DB::table(Tables::SHOP_PRODUCTS)->where('id', $image->product_id)->exists()) {
                return;
            }

            DB::table(Tables::SHOP_PRODUCT_IMAGES)->insert([
                'id'         => $image->id,
                'product_id' => $image->product_id,
                'file'       => $image->filename,
                'sort'       => $image->position,
            ]);
        });
    }

    public function productCategories()
    {
        DB::table(Tables::SHOP_PRODUCT_CATEGORIES)->delete();

        DB::table(static::DATABASE . '.s_products_categories')
            ->orderBy('product_id')->orderBy('position')
            ->get()->map(function ($relation) use (&$index, &$productId) {
                if (
                    !DB::table(Tables::SHOP_CATEGORIES)->where('id', $relation->category_id)->exists()
                    || !DB::table(Tables::SHOP_PRODUCTS)->where('id', $relation->product_id)->exists()
                ) {
                    return;
                }

                DB::table(Tables::SHOP_PRODUCT_CATEGORIES)->insert([
                    'category_id' => $relation->category_id,
                    'product_id'  => $relation->product_id,
                    'sort'        => $relation->position,
                ]);
            });
    }

    public function attributes()
    {
        DB::table(Tables::SHOP_PRODUCT_ATTRIBUTES)->delete();

        DB::table(static::DATABASE . '.s_options')->get()->map(function ($option) {
            if (
                !DB::table(Tables::SHOP_PRODUCTS)->where('id', $option->product_id)->exists()
                || !DB::table(Tables::SHOP_FEATURES)->where('id', $option->feature_id)->exists()
            ) {
                return;
            }

            DB::table(Tables::SHOP_PRODUCT_ATTRIBUTES)->insert([
                'product_id' => $option->product_id,
                'feature_id' => $option->feature_id,
                'value'      => Str::limit($option->value, 100),
            ]);
        });
    }
}

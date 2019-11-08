<?php

namespace App\Providers;

use App\Entity\Shop\Catalog\Brand;
use Illuminate\Support\ServiceProvider;
use App\Entity\Shop\Brand\BrandObserver;
use App\Entity\Shop\Catalog\Category\Category;
use App\Entity\Shop\Catalog\Product\Image\Image;
use App\Entity\Shop\Catalog\Product\Product\Product;
use App\Entity\Shop\Catalog\Category\CategoryObserver;
use App\Entity\Shop\Catalog\Product\Image\ImageObserver;
use App\Entity\Shop\Catalog\Product\Product\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        Image::observe(ImageObserver::class);
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
    }
}

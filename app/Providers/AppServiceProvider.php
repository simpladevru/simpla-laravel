<?php

namespace App\Providers;

use App\Entity\Shop\Catalog\Brand;
use App\Entity\Shop\Product\Product;
use Illuminate\Support\ServiceProvider;
use App\Entity\Shop\Product\Image\Image;
use App\Entity\Shop\Brand\BrandObserver;
use App\Entity\Shop\Catalog\Category\Category;
use App\Entity\Shop\Product\Image\ImageObserver;
use App\Entity\Shop\Catalog\Product\ProductObserver;
use App\Entity\Shop\Catalog\Category\CategoryObserver;

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

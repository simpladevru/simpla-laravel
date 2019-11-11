<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Entity\Shop\Catalog\Products\Image\Image;
use App\Entity\Shop\Catalog\Products\Image\Observer as ImageObserver;

use App\Entity\Shop\Catalog\Products\Product\Product;
use App\Entity\Shop\Catalog\Products\Product\Observer as ProductObserver;

use App\Entity\Shop\Catalog\Brand\Brand;
use App\Entity\Shop\Catalog\Brand\Observer as BrandObserver;

use App\Entity\Shop\Catalog\Category\Category;
use App\Entity\Shop\Catalog\Category\Observer as CategoryObserver;


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

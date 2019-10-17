<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entity\Shop\Product\Image\Image;
use App\Entity\Shop\Product\Image\ImageObserver;

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
        Image::observe(ImageObserver::class);
    }
}

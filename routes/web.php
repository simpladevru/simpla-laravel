<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('files/{directory}/{filename}.{width}x{height}.{extension}', 'ResizeImageController@resize')->name('resizeImage');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => Admin::class], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Shop'], function () {
        Route::group(['prefix' => 'catalog', 'as' => 'catalog.', 'namespace' => 'Catalog'], function () {
            Route::resource('products', 'ProductController');
            Route::post('products/group-action', 'ProductController@groupAction')->name('products.groupAction');

            Route::get('categories/ajax-all-with-depth', 'CategoryController@ajaxAllWithDepth')->name('categories.ajaxAllWithDepth');
            Route::resource('categories', 'CategoryController');
            Route::get('categories/{category}/ajax-features', 'CategoryController@ajaxFeatures')->name('categories.ajaxFeatures');
            Route::get('categories/{category}/children', 'CategoryController@index')->name('categories.children');

            Route::resource('brands', 'BrandController');
            Route::resource('features', 'FeatureController');
            Route::resource('comments', 'CommentController');
        });
        Route::group(['prefix' => 'order', 'as' => 'order.', 'namespace' => 'Order'], function () {
            Route::resource('orders', 'OrderController');
            Route::resource('labels', 'LabelController');
            Route::resource('coupons', 'CouponController');
        });
        Route::group(['prefix' => 'setting', 'as' => 'setting.', 'namespace' => 'Setting'], function () {
            Route::resource('currencies', 'CurrencyController');
            Route::resource('payment-methods', 'PaymentMethodController');
            Route::resource('deliveries', 'DeliveryController');
        });
    });
});

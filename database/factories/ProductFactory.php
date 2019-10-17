<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Shop\Product\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'  => \Illuminate\Support\Str::random(50),
        'price' => rand(100, 10000),
        'sort'  => 1,
    ];
});

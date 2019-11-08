<?php

use App\Entity\Region;
use Illuminate\Database\Seeder;
use App\Entity\Shop\Products\Product\Product;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        factory(Product::class, 100000)->create();
    }
}

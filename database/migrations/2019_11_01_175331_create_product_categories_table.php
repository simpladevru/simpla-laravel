<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_PRODUCT_CATEGORIES, function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('sort')->unsigned();
            $table->primary(['category_id', 'product_id']);

            $table->index('sort');

            $table->foreign('product_id')->references('id')->on(Tables::SHOP_PRODUCTS)->onDelete('CASCADE');
            $table->foreign('category_id')->references('id')->on(Tables::SHOP_CATEGORIES)->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_PRODUCT_CATEGORIES);
    }
}

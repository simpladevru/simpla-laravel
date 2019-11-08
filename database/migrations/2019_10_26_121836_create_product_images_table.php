<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_PRODUCT_IMAGES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->string('file');
            $table->integer('sort');
            $table->timestamps();

            $table->index('product_id');
            $table->index('sort');

            $table->foreign('product_id')->references('id')->on(Tables::SHOP_PRODUCTS)->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_PRODUCT_IMAGES);
    }
}

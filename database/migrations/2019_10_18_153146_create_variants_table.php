<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_PRODUCT_VARIANTS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->integer('stock')->nullable()->unsigned();
            $table->decimal('price', 14)->nullable()->unsigned();
            $table->decimal('compare_price', 14)->nullable()->unsigned();
            $table->integer('sort')->nullable()->unsigned();
            $table->timestamps();

            $table->index('product_id');
            $table->index('name');
            $table->index('sku');
            $table->index('stock');
            $table->index('price');
            $table->index('compare_price');
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
        Schema::dropIfExists(Tables::SHOP_PRODUCT_VARIANTS);
    }
}

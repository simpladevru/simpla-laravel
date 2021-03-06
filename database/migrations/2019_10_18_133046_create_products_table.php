<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_PRODUCTS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->bigInteger('brand_id')->nullable()->unsigned();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_featured')->nullable();
            $table->text('annotation')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('slug');
            $table->index('brand_id');
            $table->index('is_active');
            $table->index('is_featured');

            $table->foreign('brand_id')->references('id')->on(Tables::SHOP_BRANDS)->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_PRODUCTS);
    }
}

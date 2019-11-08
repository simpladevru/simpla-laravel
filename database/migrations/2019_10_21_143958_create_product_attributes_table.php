<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_PRODUCT_ATTRIBUTES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('feature_id')->unsigned();
            $table->string('value');
            $table->timestamps();

            $table->index('feature_id');
            $table->index('product_id');

            $table->foreign('feature_id')->references('id')->on(Tables::SHOP_FEATURES)->onDelete('CASCADE');
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
        Schema::dropIfExists(Tables::SHOP_PRODUCT_ATTRIBUTES);
    }
}

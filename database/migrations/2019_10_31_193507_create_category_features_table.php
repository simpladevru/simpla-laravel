<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_CATEGORY_FEATURES, function (Blueprint $table) {
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('feature_id')->unsigned();
            $table->primary(['category_id', 'feature_id']);

            $table->foreign('category_id')->references('id')->on(Tables::SHOP_CATEGORIES)->onDelete('CASCADE');
            $table->foreign('feature_id')->references('id')->on(Tables::SHOP_FEATURES)->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_CATEGORY_FEATURES);
    }
}

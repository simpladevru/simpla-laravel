<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_FEATURES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('in_filter');
            $table->integer('sort')->unsigned();
            $table->timestamps();

            $table->index('in_filter');
            $table->index('sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_FEATURES);
    }
}

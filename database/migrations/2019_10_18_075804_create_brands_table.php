<?php

use App\Helpers\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tables::SHOP_BRANDS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tables::SHOP_BRANDS);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->index()->nullable();
            $table->string('url')->index();
            $table->string('logo')->nullable();
            $table->float('sale')->nullable();
            $table->float('cashback_percent')->nullable();
            $table->unsignedInteger('popularity')->nullable();
            $table->boolean('featured')->default(true)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('store_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->string('locale', 2)->index();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['store_id', 'locale']);
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });

        Schema::create('store_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('store_id');

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_translations');
        Schema::dropIfExists('store_categories');
        Schema::dropIfExists('stores');
    }
}

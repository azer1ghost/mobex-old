<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->boolean('status')->default(true)->index();
            $table->boolean('has_delivery')->default(false)->index();
            $table->float('delivery_fee')->nullable();
            $table->float('km')->nullable();
            $table->string('zip_index')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('district_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('district_id');
            $table->string('locale', 2)->index();
            $table->string('name');

            $table->unique(['district_id', 'locale']);
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_translations');
        Schema::dropIfExists('districts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('warehouse_id');
            $table->string('custom_id');
            $table->boolean('sent')->default(false);
            $table->timestamps();
        });

        Schema::create('parcel_package', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parcel_id');
            $table->string('package_id');

            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_package');
        Schema::dropIfExists('parcels');
    }
}

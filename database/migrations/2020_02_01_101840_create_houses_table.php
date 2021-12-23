<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('provider', ['tap', 'bina'])->default('tap');
            $table->unsignedInteger('custom_id');
            $table->string('city')->nullable();
            $table->enum('type', ['satilir'])->default('satilir');
            $table->enum('condition', ['yeni', 'kohne'])->default('yeni');
            $table->float('area');
            $table->unsignedTinyInteger('number_of_rooms');
            $table->string('place_or_district')->nullable();
            $table->date('uploaded_at');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->date('sold_at')->nullable();
            $table->string('url');
            $table->unsignedBigInteger('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}

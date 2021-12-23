<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 190)->index();
            $table->string('name_on_card', 190)->index();
            $table->string('number', 20)->index();
            $table->string('end_date', 5);
            $table->string('cvv', 3);
            $table->enum('status', ['ACTIVE', 'PASSIVE', 'PENDING', 'ERROR'])->index()->default('ACTIVE');
            $table->text("data")->nullable();
            $table->float('limit')->nullable();
            $table->string('currency', 3)->default('TRY');
            $table->string('phone_number', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}

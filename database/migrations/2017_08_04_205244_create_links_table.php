<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->text('url');
            $table->text('note')->nullable();
            $table->text('affiliate')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('total_price')->nullable();
            $table->string('price')->nullable();
            $table->string('cargo_fee')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->unsignedTinyInteger('status')->index()->default(0);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}

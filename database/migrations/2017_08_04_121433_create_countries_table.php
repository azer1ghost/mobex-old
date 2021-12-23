<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->unsignedInteger('delivery_index')->default(6000);
            $table->string('flag')->nullable();
            $table->text('emails')->nullable();
            $table->boolean('status')->default(true)->index();
            $table->boolean('allow_declaration')->default(true)->index();
            $table->boolean('convert_invoice_to_usd')->default(false)->index();
            $table->unsignedTinyInteger('currency')->default(0);
            $table->timestamps();
        });

        Schema::create('country_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['country_id', 'locale']);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('country_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('page_id');

            $table->unique(['country_id', 'page_id']);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            //$table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_pages');
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('countries');
    }
}

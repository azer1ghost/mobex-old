<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('about_cover')->nullable();
            $table->string('shop_cover')->nullable();
            $table->string('app_store')->nullable();
            $table->string('google_play')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('tariffs_cover')->nullable();
            $table->string('calculator_cover')->nullable();
            $table->string('faq_cover')->nullable();
            $table->string('contact_cover')->nullable();
            $table->longText('contact_map')->nullable();
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
        Schema::dropIfExists('settings');
    }
}

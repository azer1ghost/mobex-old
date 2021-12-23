<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('in_order')->default(1)->index();
            $table->boolean('status')->default(1)->index();
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('faq_id')->unsigned();
            $table->string('locale', 2)->index();
            $table->text('question')->nullable();
            $table->text('answer')->nullable();

            $table->unique(['faq_id', 'locale']);
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
}
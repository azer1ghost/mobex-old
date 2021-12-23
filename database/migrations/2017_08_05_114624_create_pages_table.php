<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            // Page or News
            $table->boolean('type')->default(0)->index();
            $table->string('image')->nullable();
            $table->string('intro_image')->nullable();
            // For easy find page
            $table->string('keyword')->nullable()->index();
            $table->boolean('status')->default(1)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->string('slug')->index();
            $table->string('locale', 2)->index();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('author')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->unique(['page_id', 'locale', 'slug']);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
}
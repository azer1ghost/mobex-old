<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title')->nullable();
            $table->unsignedInteger('send_after')->default(0);
            $table->longText('content')->nullable();
            $table->text('filtering')->nullable();
            $table->longText('users')->nullable();
            $table->enum('type', ['SMS', 'EMAIL'])->default('SMS');
            $table->longText('response_data')->nullable();
            $table->boolean('sent')->default(false);
            $table->unsignedInteger('matched')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('campaigns');
    }
}

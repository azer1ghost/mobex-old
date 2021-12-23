<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['SMS', 'EMAIL'])->default('EMAIL')->index();
            $table->string('to')->nullable();
            $table->string('extra_to')->nullable();
            $table->text('subject')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('sent')->default(false);
            $table->text('error_message')->nullable();
            $table->enum('send_for', ['PACKAGE', 'CAMPAIGN'])->default('PACKAGE');
            $table->unsignedInteger('send_for_id')->nullable()->index();
            $table->unsignedTinyInteger('hour_after')->default(0);
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
        Schema::dropIfExists('notification_queues');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralUserTable extends Migration
{
    public function up()
    {
        Schema::create('referral_user', function (Blueprint $table) {
            $table->integer('user_id')->unique()->index();
            $table->string('referral_key')->nullable();
            $table->timestamp('request_time')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_user');
    }
}
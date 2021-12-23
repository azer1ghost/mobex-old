<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->index()->nullable();
            $table->string('name')->index()->nullable();
            $table->string('surname')->index()->nullable();
            $table->string('email')->index();
            $table->string('old_password')->nullable();
            $table->string('password');

            $table->string('phone')->nullable();
            $table->string('passport')->index()->nullable();
            $table->string('fin')->index()->nullable();
            $table->string('customer_id')->index()->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('city_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->unsignedInteger('filial_id')->nullable();
            $table->string('company')->nullable();
            $table->string('friend_reference')->nullable();
            $table->string('pass_key')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('birthday')->nullable();
            $table->boolean('gender')->default(true);
            $table->boolean('elite')->default(false);
            $table->float('discount')->default(0);
            $table->unsignedInteger('promo_id')->nullable();
            $table->float('liquid_discount')->default(0);

            $table->string('sms_verification_code')->index()->nullable();
            $table->boolean('sms_verification_status')->index()->default(false);
            $table->boolean('check_verify')->index()->default(true);

            $table->rememberToken();
            $table->timestamp('login_at')->nullable();
            $table->softDeletes();
            $table->enum('status', ['ACTIVE', 'PASSIVE', 'BANNED'])->index()->default('ACTIVE');
            $table->enum('type', ['USER', 'DEALER', 'COMPANY'])->index()->default('USER');
            $table->boolean('notification')->default(true);
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('users');
    }
}

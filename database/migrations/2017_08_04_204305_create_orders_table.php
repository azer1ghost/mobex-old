<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('card_id')->index()->nullable();
            $table->string('custom_id')->index();
            $table->text('note')->nullable();
            $table->text('extra_contacts')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('affiliate')->nullable();
            $table->string('price')->nullable();
            $table->string('service_fee')->nullable();
            $table->string('coupon_sale')->nullable();
            $table->string('total_price')->nullable();
            $table->boolean('paid')->default(false);
            $table->unsignedInteger('package_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedTinyInteger('status')->index()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
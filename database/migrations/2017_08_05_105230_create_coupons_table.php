<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedTinyInteger('type_id')->default(0)->index();
            $table->string('url')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();

            $table->boolean('featured')->default(true)->index();
            $table->date('end_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('coupon_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coupon_id');
            $table->string('locale', 2)->index();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['coupon_id', 'locale']);
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
        });

        Schema::create('coupon_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('coupon_id');

            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_translations');
        Schema::dropIfExists('coupon_categories');
        Schema::dropIfExists('coupons');
    }
}

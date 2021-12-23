<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('filial_id')->index()->nullable();
            $table->unsignedInteger('admin_id')->index()->nullable();
            $table->unsignedInteger('city_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->unsignedInteger('tariff_id')->index()->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->text('courier_note')->nullable();
            $table->boolean('fast')->default(false);

            $table->float('fee')->nullable();
            $table->float('total_weight')->nullable();
            $table->float('total_price')->nullable();
            $table->boolean('paid')->default(false);
            $table->unsignedTinyInteger('status')->default(0)->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('delivery_package', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('delivery_id')->nullable();
            $table->unsignedInteger('package_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_package');
        Schema::dropIfExists('deliveries');
    }
}

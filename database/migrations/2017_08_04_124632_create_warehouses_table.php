<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->unsignedInteger('country_id')->nullable();

            /* Tariffs */
            $table->float('to_100g')->nullable();
            $table->float('from_100g_to_200g')->nullable();
            $table->float('from_200g_to_500g')->nullable();
            $table->float('from_500g_to_750g')->nullable();
            $table->float('from_750g_to_1kq')->nullable();

            $table->float('half_kg')->nullable();
            $table->float('per_kg')->nullable();
            $table->float('from_1kq_to_5kq')->nullable();
            $table->float('from_5kq_to_10kq')->nullable();
            $table->double('per_g', 8, 6)->nullable();
            $table->float('up_10_kg');

            /* Tariffs for liquid */
            $table->boolean('has_liquid')->default(false);
            $table->float('l_to_100g')->nullable();
            $table->float('l_from_100g_to_200g')->nullable();
            $table->float('l_from_200g_to_500g')->nullable();
            $table->float('l_from_500g_to_750g')->nullable();
            $table->float('l_from_750g_to_1kq')->nullable();

            $table->float('l_half_kg')->nullable();
            $table->float('l_per_kg')->nullable();
            $table->float('l_from_1kq_to_5kq')->nullable();
            $table->float('l_from_5kq_to_10kq')->nullable();
            $table->double('l_per_g', 8, 6)->nullable();
            $table->float('l_up_10_kg')->nullable();

            $table->string('key')->nullable();
            $table->unsignedTinyInteger('currency')->default(0);
            $table->string('per_week', 4)->default(1);

            $table->boolean('parcelling')->default(false);
            $table->boolean('auto_print')->default(false);
            $table->boolean('allow_make_fake_invoice')->default(false);
            $table->boolean('only_weight_input')->default(false);
            $table->boolean('show_invoice')->default(true);
            $table->boolean('show_label')->default(true);

            $table->string('email');
            $table->string('password');

            $table->string('panel_login')->nullable();
            $table->string('panel_password')->nullable();

            $table->float('limit_weight')->nullable();

            $table->float('limit_amount')->nullable();
            $table->unsignedTinyInteger('limit_currency')->default(0);

            // Cells
            $table->text('main_cells')->nullable();
            $table->text('liquid_cells')->nullable();
            $table->text('battery_cells')->nullable();
            $table->float('cell_limit_weight')->default(16);
            $table->float('cell_limit_amount')->default(0);

            $table->string('web_site')->nullable();
            $table->unsignedInteger('label')->default(1);
            $table->unsignedInteger('invoice')->default(1);


            /* Discount  */
            $table->float('discount_dealer')->default(0);
            $table->float('liquid_discount_dealer')->default(0);

            $table->float('discount_user')->default(0);
            $table->float('liquid_discount_user')->default(0);

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('warehouses');
    }
}

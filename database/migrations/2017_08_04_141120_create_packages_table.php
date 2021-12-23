<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->unsignedInteger('worker_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('custom_id')->unique()->index();
            $table->float('gross_weight')->nullable();
            $table->float('weight')->nullable();
            $table->unsignedTinyInteger('weight_type')->default(0);
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('length')->nullable();
            $table->unsignedTinyInteger('length_type')->default(0);
            $table->string('tracking_code')->nullable()->index();

            $table->string('custom_awb')->nullable()->index();
            $table->string('custom_parcel_number')->nullable()->index();

            $table->string('website_name')->nullable()->index();
            $table->unsignedInteger('type_id')->nullable()->index();
            $table->text('other_type')->nullable();
            $table->unsignedInteger('number_items')->nullable();
            $table->float('shipping_amount')->unsigned()->nullable();
            $table->unsignedTinyInteger('shipping_amount_cur')->default(0);
            $table->string('invoice')->nullable();
            $table->text('user_comment')->nullable();
            $table->text('warehouse_comment')->nullable();
            $table->string('screen_file')->nullable();
            $table->text('admin_comment')->nullable();
            $table->boolean('show_label')->default(false);
            $table->boolean('declaration')->nullable();
            $table->float('delivery_price')->nullable();
            $table->float('shipping_fee')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->index();
            $table->unsignedTinyInteger('dec_message')->default(0);
            $table->boolean('paid')->default(false);
            $table->boolean('has_liquid')->default(false);
            $table->boolean('has_battery')->default(false);
            $table->boolean('print_invoice')->default(true);
            $table->boolean('check_limit')->default(true);
            $table->softDeletes();
            $table->timestamp("arrived_at")->index()->nullable();
            $table->timestamp("sent_at")->index()->nullable();
            $table->timestamp("scanned_at")->index()->nullable();
            $table->timestamp("requested_at")->index()->nullable();
            $table->timestamp("done_at")->index()->nullable();
            $table->string("cell", 4)->index()->nullable();
            $table->string("warehouse_cell", 4)->index()->nullable();
            $table->text("detailed_type")->nullable();
            $table->text("categories")->nullable();
            $table->tinyInteger('custom_status')->nullable();
            $table->text('custom_comment')->nullable();
            $table->text('custom_data')->nullable();
            $table->string('reg_number')->nullable();
            $table->unsignedTinyInteger('notified')->default(0);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('package_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}

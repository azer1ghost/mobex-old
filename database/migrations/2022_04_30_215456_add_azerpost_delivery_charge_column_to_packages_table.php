<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAzerpostDeliveryChargeColumnToPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('packages', function($table) {
            $table->string('azerpost_delivery_charge', 10)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function($table) {
            $table->dropColumn('azerpost_delivery_charge');
        });
    }
}

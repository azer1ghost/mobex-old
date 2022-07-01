<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeePerKqColumnToAzerpoctBranchesTable extends Migration
{
    public function up()
    {
        Schema::table('azerpoct_branches', function (Blueprint $table) {
            $table->double('fee_per_kq');
        });
    }

    public function down()
    {
        Schema::table('azerpoct_branches', function (Blueprint $table) {
            $table->dropColumn('fee_per_kq');
        });
    }
}
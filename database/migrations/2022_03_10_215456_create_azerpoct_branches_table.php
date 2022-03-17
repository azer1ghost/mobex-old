<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAzerpoctBranchesTable extends Migration
{
    public function up()
    {
        Schema::create('azerpoct_branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string("zip_code")->nullable();
            $table->string("address")->nullable();
            $table->string("home")->nullable();
            $table->string("postalDescription")->nullable();
            $table->string("phoneNumber")->nullable();
            $table->string("longitude")->nullable();
            $table->string("latitude")->nullable();
            $table->string("workDays")->nullable();
            $table->string("saturday")->nullable();
            $table->string("sundayAndHolidays")->nullable();
            $table->string("breakTime")->nullable();
            $table->string("regionAZ")->nullable();
            $table->string("regionEN")->nullable();
            $table->enum('status', ['ACTIVE', 'PASSIVE'])->default('ACTIVE');
            $table->float("fee")->nullable();
            $table->index('zip_code');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('packages', function($table) {
            $table->text('zip_code')->nullable();
            $table->text('azerpoct_response_log')->nullable();
            $table->integer('azerpoct_status')->nullable()->default(null);
        });

        Schema::table('users', function($table) {
            $table->boolean('sent_by_post')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azerpoct_branches');
        Schema::table('packages', function($table) {
            $table->dropColumn('zip_code');
        });
        Schema::table('users', function($table) {
            $table->dropColumn('sent_by_post');
        });

    }
}

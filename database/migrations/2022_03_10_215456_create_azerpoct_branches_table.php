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
            $table->text("location")->nullable();
            $table->text("phone")->nullable();
            $table->text("zip_code")->nullable();
            $table->enum('status', ['ACTIVE', 'PASSIVE'])->default('ACTIVE');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('packages', function($table) {
            $table->text('zip_code')->nullable()->default(null);
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

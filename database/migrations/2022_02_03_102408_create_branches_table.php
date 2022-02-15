<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->text("location")->nullable();
            $table->text("phone")->nullable();
            $table->text("working_hours")->nullable();
            $table->enum('status', ['ACTIVE', 'PASSIVE'])->default('ACTIVE');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('branch_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('branch_id');
            $table->string('locale', 2)->index();
            $table->string('name');
            $table->text('address')->nullable();

            $table->unique(['branch_id', 'locale']);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });

        Schema::table('users', function($table) {
            $table->integer('branch_id')->nullable()->default(null);
        });

        Schema::table('packages', function($table) {
            $table->integer('branch_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');

        Schema::table('users', function($table) {
            $table->dropColumn('branch_id');
        });

        Schema::table('packages', function($table) {
            $table->dropColumn('branch_id');
        });
    }
}
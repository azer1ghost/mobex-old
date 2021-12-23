<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('icon')->nullable();
            $table->float('weight')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('package_types')->onDelete('set null');
        });

        Schema::create('package_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_type_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['package_type_id', 'locale']);
            $table->foreign('package_type_id')->references('id')->on('package_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_type_translations');
        Schema::dropIfExists('package_types');
    }
}

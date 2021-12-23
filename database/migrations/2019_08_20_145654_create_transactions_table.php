<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('referral_id')->index()->nullable();
            $table->unsignedInteger('warehouse_id')->index()->nullable();
            $table->unsignedInteger('filial_id')->index()->nullable();
            $table->unsignedInteger('custom_id')->index()->nullable();
            $table->enum('paid_for', ['ORDER', 'PACKAGE', 'COURIER', 'ORDER_BALANCE', 'PACKAGE_BALANCE', 'PACKAGE_SHIPPING', 'SERVICE_FEE'])->index()->nullable();
            $table->enum('paid_by', ['BONUS', 'GIFT_CARD', 'CASH', 'PAY_TR', 'PAYMES', 'MILLION', 'PORTMANAT', 'POST_TERMINAL', 'REFERRAL', 'CASHBACK', 'PACKAGE_BALANCE', 'ORDER_BALANCE', 'CREDIT_CARD', 'EMANAT', 'HESABAZ', 'CARD_TO_CARD', 'OTHER'])->index()->nullable();
            $table->enum('type', ['IN', 'OUT', 'DEBT', 'ERROR', 'REFUND'])->index()->deafult('IN');
            $table->enum('who', ['USER', 'ADMIN'])->index()->deafult('USER');
            $table->enum('currency', ['AZN', 'TRY', 'USD'])->index()->deafult('AZN');
            $table->float('rate', 8, 4)->nullable()->default(1);
            $table->float('amount')->nullable();
            $table->text('note')->nullable();
            $table->text('extra_data')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

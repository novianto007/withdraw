<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('bank_code');
            $table->string('account_number');
            $table->bigInteger('amount');
            $table->string('remark');
            $table->string('status');
            $table->integer('trx_id')->nullable();
            $table->string('receipt')->nullable();
            $table->integer('fee')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->timestamp('last_check')->nullable();
            $table->timestamp('time_served')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}

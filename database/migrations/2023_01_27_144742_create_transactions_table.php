<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->bigInteger('amount');
            $table->string('ref_num');
            $table->string('transaction_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('status')->nullable();
            $table->boolean('success')->default(false);
            $table->timestamps();
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
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pg_penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->string('masked_card', 100)->nullable();
            $table->string('approval_code', 100)->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('eci', 100)->nullable();
            $table->string('channel_response_code', 100)->nullable();
            $table->string('channel_response_message', 100)->nullable();
            $table->string('transaction_time', 100)->nullable();
            $table->string('gross_amount', 100)->nullable();
            $table->string('currency', 100)->nullable();
            $table->string('order_id', 100)->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->string('signature_key', 128)->nullable();
            $table->string('status_code', 100)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('transaction_status', 100)->nullable();
            $table->string('fraud_status', 100)->nullable();
            $table->dateTime('settlement_time')->nullable();
            $table->string('status_message', 100)->nullable();
            $table->string('merchant_id', 100)->nullable();
            $table->string('card_type', 100)->nullable();
            $table->timestamps();
        });

        // Insert initial data
        DB::table('pg_penjualan')->insert([
            [
                'id_penjualan' => 5,
                'transaction_time' => '2024-06-10 17:11:42',
                'gross_amount' => '5000.00',
                'order_id' => '1818905480',
                'payment_type' => 'bank_transfer',
                'status_code' => '200',
                'transaction_id' => '8ec09962-fc0b-4f13-83aa-5724d955a0f5',
                'transaction_status' => 'settlement',
                'settlement_time' => '2024-06-10 17:11:52',
                'status_message' => 'Success, transaction is found',
                'merchant_id' => 'G913881209'
            ],
            [
                'id_penjualan' => 6,
                'transaction_time' => '2024-06-10 23:11:30',
                'gross_amount' => '2000.00',
                'order_id' => '1218179952',
                'payment_type' => 'bank_transfer',
                'status_code' => '200',
                'transaction_id' => 'f4483d0d-b709-43cb-b649-b1a9419aa1d1',
                'transaction_status' => 'settlement',
                'settlement_time' => '2024-06-10 23:11:47',
                'status_message' => 'Success, transaction is found',
                'merchant_id' => 'G913881209'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_penjualan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->dateTime('tgl_bayar');
            $table->dateTime('tgl_konfirmasi')->nullable();
            $table->string('bukti_bayar');
            $table->string('jenis_pembayaran');
            $table->string('status');
            $table->timestamps();
        });

        DB::table('pembayaran')->insert([
            [
                'no_transaksi' => 'FK-0001',
                'tgl_bayar' => '2024-06-10 17:11:42',
                'tgl_konfirmasi' => '2024-06-10 17:11:53',
                'bukti_bayar' => 'midtrans-logo.png',
                'jenis_pembayaran' => 'pg',
                'status' => 'approved',
                'created_at' => '2024-06-10 10:11:53',
                'updated_at' => '2024-06-10 10:11:53'
            ],
            [
                'no_transaksi' => 'FK-0002',
                'tgl_bayar' => '2024-06-10 23:11:30',
                'tgl_konfirmasi' => '2024-06-10 23:11:50',
                'bukti_bayar' => 'midtrans-logo.png',
                'jenis_pembayaran' => 'pg',
                'status' => 'approved',
                'created_at' => '2024-06-10 16:11:50',
                'updated_at' => '2024-06-10 16:11:50'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

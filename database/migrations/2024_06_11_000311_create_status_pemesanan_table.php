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
        Schema::create('status_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('status', 50)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('deskripsi', 50);
            $table->timestamps();
        });

        // Insert initial data
        DB::table('status_pemesanan')->insert([
            [
                'id' => 1,
                'status' => 'pesan',
                'deskripsi' => 'Pemesanan Barang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'status' => 'siap_bayar',
                'deskripsi' => 'Checkout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'status' => 'konfirmasi_bayar',
                'deskripsi' => 'Konfirmasi Pembayaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'status' => 'selesai',
                'deskripsi' => 'Pesanan Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'status' => 'expired',
                'deskripsi' => 'Pesanan Expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pemesanan');
    }
};

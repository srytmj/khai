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
        Schema::create('status_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 7)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('id_customer');
            $table->string('status', 20)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->dateTime('waktu');
            $table->timestamps();
        });

        // Insert initial data
        DB::table('status_transaksi')->insert([
            [
                'id' => 28,
                'no_transaksi' => 'FK-0001',
                'id_customer' => 4,
                'status' => 'pesan',
                'waktu' => '2024-06-10 17:08:03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 29,
                'no_transaksi' => 'FK-0001',
                'id_customer' => 4,
                'status' => 'siap_bayar',
                'waktu' => '2024-06-10 17:08:05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 30,
                'no_transaksi' => 'FK-0002',
                'id_customer' => 4,
                'status' => 'pesan',
                'waktu' => '2024-06-10 23:10:29',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 31,
                'no_transaksi' => 'FK-0002',
                'id_customer' => 4,
                'status' => 'siap_bayar',
                'waktu' => '2024-06-10 23:11:23',
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
        Schema::dropIfExists('status_transaksi');
    }
};

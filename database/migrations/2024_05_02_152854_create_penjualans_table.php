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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 7);
            $table->unsignedBigInteger('id_customer');
            $table->dateTime('tgl_transaksi');
            $table->dateTime('tgl_expired');
            $table->integer('total_harga');
            $table->string('status');
            $table->timestamps();
        });

        // DB::table('penjualan')->insert([
        //     [
        //         'id' => 1,
        //         'no_transaksi' => 'FK-0001',
        //         'id_customer' => 1,
        //         'tgl_transaksi' => '2024-06-10 17:08:03',
        //         'tgl_expired' => '2024-06-13 17:08:03',
        //         'total_harga' => 5000,
        //         'status' => 'selesai',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'id' => 2,
        //         'no_transaksi' => 'FK-0002',
        //         'id_customer' => 1,
        //         'tgl_transaksi' => '2024-06-10 23:10:29',
        //         'tgl_expired' => '2024-06-13 23:10:29',
        //         'total_harga' => 2000,
        //         'status' => 'selesai',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]
        // ]);

        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 255)->nullable();
            $table->unsignedBigInteger('id_menu')->nullable();
            $table->integer('harga_menu')->nullable();
            $table->integer('jml_barang')->nullable();
            $table->integer('total')->nullable();
            $table->dateTime('tgl_transaksi')->nullable();
            $table->dateTime('tgl_expired')->nullable();
            $table->timestamps();
        });

        // DB::table('penjualan_detail')->insert([
        //     [
        //         'id' => 1,
        //         'no_transaksi' => 'FK-0001',
        //         'id_menu' => 1,
        //         'harga_menu' => 1000,
        //         'jml_barang' => 5,
        //         'total' => 5000,
        //         'tgl_transaksi' => '2024-06-10 17:08:03',
        //         'tgl_expired' => '2024-06-13 17:08:03',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'id' => 2,
        //         'no_transaksi' => 'FK-0002',
        //         'id_menu' => 1,
        //         'harga_menu' => 1000,
        //         'jml_barang' => 2,
        //         'total' => 2000,
        //         'tgl_transaksi' => '2024-06-10 23:10:29',
        //         'tgl_expired' => '2024-06-13 23:10:29',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('penjualan_detail');
    }
};

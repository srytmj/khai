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
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('kode_menu');
            $table->string('nama_menu');
            $table->integer('harga_menu');
            $table->integer('stok');
            $table->timestamps();
        });

        DB::table('menu')->insert([
            [
                'kode_menu' => 'MNU-001',
                'nama_menu' => 'Kopi Hitam',
                'harga_menu' => 10000,
                'stok' => 10,
            ],
            [
                'kode_menu' => 'MNU-002',
                'nama_menu' => 'Mie',
                'harga_menu' => 25000,
                'stok' => 12,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
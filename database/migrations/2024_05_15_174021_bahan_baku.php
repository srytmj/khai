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
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahanbaku');
            $table->string('nama_bahanbaku');
            $table->integer('kuantitas')->default(0);
            $table->integer('harga');
            $table->timestamps();
        });

        // insert some data
        DB::table('bahan_baku')->insert([
            [
                'kode_bahanbaku' => 'BB-001',
                'nama_bahanbaku' => 'Beras',
                'kuantitas' => 100,
                'harga' => 10000,
            ],
            [
                'kode_bahanbaku' => 'BB-002',
                'nama_bahanbaku' => 'Gula',
                'kuantitas' => 200,
                'harga' => 20000,
            ],
            [
                'kode_bahanbaku' => 'BB-003',
                'nama_bahanbaku' => 'Kopi',
                'kuantitas' => 300,
                'harga' => 30000,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};

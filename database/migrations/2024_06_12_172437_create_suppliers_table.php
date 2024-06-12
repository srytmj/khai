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
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier', 6) -> unique();
            $table->string('nama_supplier', 30);
            $table->string('alamat_supplier');
            $table->string('nama_bahanbaku');
            $table->bigInteger('kuantitas')->default(0);
            $table->bigInteger('harga');
            $table->timestamps();
        });

        DB::table('supplier')->insert([
            [
                'kode_supplier' => 'DS001',
                'nama_supplier' => 'Supplier Utama',
                'alamat_supplier' => 'Jl. Raya No.1, Jakarta',
                'nama_bahanbaku' => 'Beras',
                'kuantitas' => 100,
                'harga' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_supplier' => 'DS002',
                'nama_supplier' => 'Supplier Kedua',
                'alamat_supplier' => 'Jl. Raya No.2, Jakarta',
                'nama_bahanbaku' => 'Gula',
                'kuantitas' => 200,
                'harga' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_supplier' => 'DS003',
                'nama_supplier' => 'Supplier Ketiga',
                'alamat_supplier' => 'Jl. Raya No.3, Jakarta',
                'nama_bahanbaku' => 'Kopi',
                'kuantitas' => 300,
                'harga' => 30000,
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
        Schema::dropIfExists('supplier');
    }
};

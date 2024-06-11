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
        Schema::create('coa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_akun');
            $table->string('nama_akun');
            $table->string('header_akun');
            $table->string('id_perusahaan')->default('1');
            $table->timestamps();
        });

        DB::table('coa')->insert([
            [
                'kode_akun' => '111',
                'nama_akun' => 'Kas',
                'header_akun' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_akun' => '411',
                'nama_akun' => 'Pendapatan',
                'header_akun' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
    }
};

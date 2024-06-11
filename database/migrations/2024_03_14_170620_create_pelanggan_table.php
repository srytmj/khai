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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_pelanggan')->unique();
            $table->string('nama_pelanggan')->unique();
            $table->string('alamat');
            $table->string('no_hp');
            $table->timestamps();
        });

        DB::table('pelanggan')->insert([
            [
                'kode_pelanggan' => 'PL-001',
                'nama_pelanggan' => 'Manda',
                'alamat' => 'bandung',
                'no_hp' => '08116091946',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};

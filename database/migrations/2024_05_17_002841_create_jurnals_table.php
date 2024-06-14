<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_transaksi');
            $table->integer('id_perusahaan');
            $table->string('kode_akun');
            $table->datetime('tgl_jurnal');
            $table->string('posisi_d_c');
            $table->integer('nominal');
            $table->string('kelompok');
            $table->string('transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};

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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 50);
            $table->string('alamat_perusahaan', 100);
            $table->timestamps();
        });

        // Insert initial data
        DB::table('perusahaan')->insert([
            [
                'id' => 1,
                'nama_perusahaan' => 'Welgroww',
                'alamat_perusahaan' => 'Jl. Raya Tumbuh Baik',
                'created_at' => '2024-06-10 15:58:31',
                'updated_at' => '2024-06-10 15:58:31'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};

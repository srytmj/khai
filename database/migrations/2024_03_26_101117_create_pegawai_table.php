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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pegawai');
            $table->string('nama_pegawai');
            $table->text('alamat');
            $table->string('jabatan');
            $table->string('no_hp');
            $table->string('jenis_kelamin');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign key constraint if you have users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Insert some data
        DB::table('pegawai')->insert([
            'kode_pegawai' => 'PGW001',
            'nama_pegawai' => 'John Doe',
            'alamat' => 'Jl. Jendral Sudirman No. 123',
            'jabatan' => 'Manager',
            'no_hp' => '081234567890',
            'jenis_kelamin' => 'Laki-laki',
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};

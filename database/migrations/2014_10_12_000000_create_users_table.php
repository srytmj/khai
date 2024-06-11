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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert initial data
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Fitria Imanda Satriawan',
                'email' => 'satriawanmandafit1515@gmail.com',
                'password' => '$2y$12$lOcLmDXGvN.gcX9SXzR92OMfoAcQgILBlaLt7ECE86zQSX6aEKmJO',
                'created_at' => '2024-03-25 14:41:22',
                'updated_at' => '2024-03-25 14:41:22',
            ],
            [
                'id' => 2,
                'name' => 'ayam',
                'email' => 'fghj@gmail.com',
                'password' => '$2y$12$PQnmHl7XGZMuPk0/2/GGguEY.H/uY3axKAUHteCDqXazOhEWS5oE.',
                'created_at' => '2024-04-06 14:15:22',
                'updated_at' => '2024-04-06 14:15:22',
            ],
            [
                'id' => 3,
                'name' => 'user',
                'email' => 'user@mail.com',
                'password' => '$2y$12$.Il7bauJz4Aq7nmjG4lPK.lmQIlXDhKM7Ry1FRtJXIceEiFulAI4i',
                'created_at' => '2024-05-12 13:30:52',
                'updated_at' => '2024-05-12 13:30:52',
            ],
            [
                'id' => 4,
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => '$2y$12$wmSWrEcxj3qwP9rbOfuZiu4pE4tskR3JI70Gxh6pExXXmKyG5iOzm',
                'created_at' => '2024-06-10 10:05:06',
                'updated_at' => '2024-06-10 10:05:06',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

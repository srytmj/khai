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
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => '$2y$12$Jp8ojz7AsH4WV04aZaf4g.w.LrBzord.SqqKdp/IqwzKU3VF.H/jG',
                'created_at' => '2024-03-25 14:41:22',
                'updated_at' => '2024-03-25 14:41:22',
            ],
            [
                'id' => 2,
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => '$2y$12$Jp8ojz7AsH4WV04aZaf4g.w.LrBzord.SqqKdp/IqwzKU3VF.H/jG',
                'created_at' => '2024-04-06 14:15:22',
                'updated_at' => '2024-04-06 14:15:22',
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

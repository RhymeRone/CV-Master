<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migration - Admins Tablosu
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable(); // Profil resmi yolu
            $table->string('phone')->nullable(); // Telefon numarası
            $table->text('address')->nullable(); // Adres bilgisi
            $table->text('bio')->nullable(); // Kısa biyografi/hakkında
            $table->string('position')->nullable(); // Pozisyon veya unvan
            $table->string('website')->nullable(); // Kişisel web sitesi
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

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
        Schema::create('cv_information', function (Blueprint $table) {
            $table->id();
            
            // Kişisel Bilgiler
            $table->string('name')->nullable()->comment('Adı');
            $table->string('slogan')->nullable()->comment('Slogan (Virgülle ayırınız)');
            $table->date('birthday')->nullable()->comment('Doğum Tarihi');
            $table->string('degree')->nullable()->comment('En Son Lisans Derecesi');
            
            // İletişim Bilgileri
            $table->string('email')->unique()->comment('E-posta adresi');
            $table->string('phone')->nullable()->comment('Telefon numarası');
            $table->text('address')->nullable()->comment('Adres');
            
            // Profesyonel Bilgiler
            $table->text('experience')->nullable()->comment('İş deneyimi');
            $table->enum('freelance', ['available', 'unavailable'])->default('unavailable')->comment('Serbest çalışma durumu')  ;
            $table->integer('clients')->default(0)->unsigned()->comment('Müşteri sayısı');
            $table->integer('projects')->default(0)->unsigned()->comment('Proje sayısı');
            
            // Sosyal Medya Linkleri
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            
            // Medya Dosyaları
            $table->string('image')->nullable()->comment('Profil fotoğrafı');
            $table->string('cv_file')->nullable()->comment('CV dosyası');
            
            $table->timestamps();
            $table->softDeletes(); // Silinen kayıtları tutmak için
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_information');
    }
};

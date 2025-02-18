<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            
            // İş deneyimi bilgileri
            $table->string('position')->comment('Pozisyon adı');
            $table->string('company')->comment('Şirket adı');
            $table->year('start_year')->comment('Başlangıç yılı');
            $table->year('end_year')->nullable()->comment('Bitiş yılı (Halen devam ediyorsa null)');
            
            // İlişki
            $table->foreignId('cv_information_id')
                ->constrained('cv_information')
                ->onDelete('cascade')
                ->comment('CV bilgisi ID');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
}; 
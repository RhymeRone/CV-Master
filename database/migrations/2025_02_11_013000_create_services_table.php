<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Hizmet bilgileri
            $table->string('name')->comment('Hizmet adı');
            $table->text('description')->comment('Hizmet açıklaması');
            $table->string('icon')->comment('Font Awesome ikon ismi');
            
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
        Schema::dropIfExists('services');
    }
}; 
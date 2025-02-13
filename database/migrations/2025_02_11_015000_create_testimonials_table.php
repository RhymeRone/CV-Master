<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            
            // Referans bilgileri
            $table->string('name')->comment('Referans veren kişinin adı');
            $table->text('comment')->comment('Referans yorumu');
            $table->string('job')->comment('Referans veren kişinin mesleği');
            $table->string('image')->comment('Referans veren kişinin fotoğrafı');
            
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
        Schema::dropIfExists('testimonials');
    }
}; 
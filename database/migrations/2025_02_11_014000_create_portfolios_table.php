<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            
            // Portfolyo bilgileri
            $table->string('name')->comment('Portfolyo adı');
            $table->text('description')->nullable()->comment('Portfolyo açıklaması');
            $table->string('link')->nullable()->comment('Proje linki');
            $table->string('image')->comment('Portfolyo görseli');
            
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
        Schema::dropIfExists('portfolios');
    }
}; 
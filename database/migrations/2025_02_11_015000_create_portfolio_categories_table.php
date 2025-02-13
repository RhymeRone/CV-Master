<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_categories', function (Blueprint $table) {
            $table->id();
            
            // Kategori bilgileri
            $table->string('name')->comment('Kategori adı');
            $table->string('slug')->unique()->comment('SEO dostu URL');
            $table->string('icon')->comment('Font Awesome ikon ismi');
            
            // İlişki
            $table->foreignId('cv_information_id')
                ->constrained('cv_information')
                ->onDelete('cascade')
                ->comment('CV bilgisi ID');
            
            $table->timestamps();
            $table->softDeletes();
        });

        // Portfolyo ve kategori arasındaki çoktan çoğa ilişki için pivot tablo
        Schema::create('portfolio_portfolio_category', function (Blueprint $table) {
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->foreignId('portfolio_category_id')->constrained()->onDelete('cascade');
            $table->primary(['portfolio_id', 'portfolio_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_portfolio_category');
        Schema::dropIfExists('portfolio_categories');
    }
}; 
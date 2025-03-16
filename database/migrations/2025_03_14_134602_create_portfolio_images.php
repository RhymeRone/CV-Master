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
        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('image_path')->comment('Görsel dosya yolu');
            $table->boolean('is_main')->default(false)->comment('Ana görsel mi?');
            $table->integer('sort_order')->default(0)->comment('Sıralama sırası');
            $table->timestamps();
            
            // Aynı portfolyo için bir ana görsel olmasını sağla
            $table->index(['portfolio_id', 'is_main']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_images');
    }
};

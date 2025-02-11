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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            
            // Skill bilgileri
            $table->string('name')->comment('Yetenek adı');
            $table->unsignedTinyInteger('level')
            ->default(75)
            ->comment('Yetenek seviyesi (0-100 arası)');
            
            $table->string('color', 7)->default('#4A90E2')->comment('Renk kodu (Hex)');
            
            // İlişki
            $table->foreignId('cv_information_id')
                ->constrained('cv_information')
                ->onDelete('cascade')
                ->comment('CV bilgisi ID');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};

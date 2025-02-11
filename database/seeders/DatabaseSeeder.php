<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CVInformation;
use App\Models\Skill;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // CV bilgilerini oluştur
        $cv = CVInformation::factory()->create();

        // Factory kullanarak rastgele 8 skill oluştur
        Skill::factory()
            ->count(8)
            ->create([
                'cv_information_id' => $cv->id
            ]);
        
    }
}

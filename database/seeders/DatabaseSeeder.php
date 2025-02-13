<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CVInformation;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\PortfolioCategory;

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
        
        // Factory kullanarak rastgele 5 deneyim oluştur
        Experience::factory()
            ->count(5)
            ->create([
                'cv_information_id' => $cv->id
            ]);

        // Factory kullanarak rastgele 6 hizmet oluştur
        Service::factory()
            ->count(6)
            ->create([
                'cv_information_id' => $cv->id
            ]);

        // Factory kullanarak rastgele 4 portfolyo oluştur
        Portfolio::factory()
            ->count(4)
            ->create([
                'cv_information_id' => $cv->id
            ]);

        // Factory kullanarak rastgele 3 referans oluştur
        Testimonial::factory()
            ->count(3)
            ->create([
                'cv_information_id' => $cv->id
            ]);

        // Factory kullanarak rastgele 6 kategori oluştur
        $categories = PortfolioCategory::factory()
            ->count(6)
            ->create([
                'cv_information_id' => $cv->id
            ]);

        // Her portfolyoya rastgele 1-3 kategori ata
        Portfolio::all()->each(function ($portfolio) use ($categories) {
            $portfolio->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}

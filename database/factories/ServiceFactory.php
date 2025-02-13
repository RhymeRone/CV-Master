<?php

namespace Database\Factories;

use App\Models\CVInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Web Geliştirme',
                'Mobil Uygulama Geliştirme',
                'UI/UX Tasarım',
                'SEO Optimizasyonu',
                'Veritabanı Yönetimi',
                'API Geliştirme'
            ]),
            'description' => $this->faker->paragraph(),
            'icon' => $this->faker->randomElement([
                'fa-code',
                'fa-mobile',
                'fa-paint-brush',
                'fa-search',
                'fa-database',
                'fa-plug'
            ]),
        ];
    }
} 
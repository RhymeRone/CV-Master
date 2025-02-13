<?php

namespace Database\Factories;

use App\Models\CVInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioCategory>
 */
class PortfolioCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Web Tasarım',
            'Mobil Uygulama',
            'UI/UX',
            'Grafik Tasarım',
            'E-Ticaret',
            'Kurumsal Kimlik'
        ]);

        return [
            'name' => $name,
            'icon' => $this->faker->randomElement([
                'fa-globe',
                'fa-mobile-alt',
                'fa-pencil-ruler',
                'fa-palette',
                'fa-shopping-cart',
                'fa-building'
            ]),
        ];
    }
} 
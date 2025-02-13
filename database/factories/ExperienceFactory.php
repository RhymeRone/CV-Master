<?php

namespace Database\Factories;

use App\Models\CVInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = $this->faker->numberBetween(2010, date('Y'));
        $endYear = $this->faker->optional(0.8)->numberBetween($startYear, date('Y'));

        return [
            'position' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'start_year' => $startYear,
            'end_year' => $endYear,
        ];
    }
} 
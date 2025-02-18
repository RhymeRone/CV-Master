<?php

namespace Database\Factories;

use App\Models\CVInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'comment' => $this->faker->paragraph(),
            'job' => $this->faker->jobTitle(),
            'image' => 'testimonial/images/default.jpg', // Varsayılan bir görsel
        ];
    }
} 
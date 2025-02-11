<?php

namespace Database\Factories;

use App\Models\CVInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'PHP', 'Laravel', 'JavaScript', 'Vue.js', 
                'React', 'Node.js', 'MySQL', 'PostgreSQL',
                'Docker', 'AWS', 'Git', 'HTML/CSS'
            ]),
            'level' => $this->faker->numberBetween(60, 100),
            'color' => $this->faker->hexColor(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CVInformation>
 */
class CVInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Kişisel Bilgiler
            'name' => $this->faker->name(),
            'slogan' => implode(', ', $this->faker->randomElements(
                [
                    'Full Stack Developer',
                    'Frontend Developer',
                    'Backend Developer',
                    'Mobile Developer',
                    'UI/UX Designer',
                    'DevOps Engineer',
                    'QA Engineer',
                    'Project Manager',
                    'Scrum Master',
                    'Product Owner'
                ],
                $this->faker->numberBetween(1, 3) // 1 ile 3 arasında rastgele sayıda eleman seç
            )),
            'birthday' => $this->faker->date('Y-m-d', '-25 years'),
            'degree' => $this->faker->randomElement(['Lisans', 'Yüksek Lisans', 'Doktora']),
            
            // İletişim Bilgileri
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            
            // Profesyonel Bilgiler
            'experience' => $this->faker->paragraphs(3, true),
            'freelance' => $this->faker->randomElement(['available', 'unavailable']),
            'clients' => $this->faker->numberBetween(0, 50),
            'projects' => $this->faker->numberBetween(5, 100),
            
            // Sosyal Medya Linkleri
            'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName(),
            'github' => 'https://github.com/' . $this->faker->userName(),
            'twitter' => 'https://twitter.com/' . $this->faker->userName(),
            'facebook' => 'https://facebook.com/' . $this->faker->userName(),
            'instagram' => 'https://instagram.com/' . $this->faker->userName(),
            'website' => $this->faker->url(),
            
            // Medya Dosyaları
            'image' => 'profile-images/' . $this->faker->image('public/storage/profile-images', 400, 400, null, false),
            'cv_file' => 'cv-files/' . $this->faker->file('public/storage/cv-files', 'public/storage/cv-files', false),
            
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

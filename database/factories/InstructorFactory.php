<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'about' => fake()->paragraph(3),
            'sub_title' => fake()->text(20),
            'youtube_link' => fake()->url(),
            'website' => fake()->domainName(),
            'twitter_link' => fake()->url(),
            'linkedin_link' => fake()->url(),

        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildInformationHistory>
 */
class ChildInformationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => fake()->randomNumber(),
            'parent_id' => fake()->randomNumber(),
            'image' => NULL,
            'child_id' => fake()->randomNumber(),
            'behavior' => fake()->text(),
            'assessment' => fake()->text(),
        ];
    }
}

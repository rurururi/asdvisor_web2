<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildStatsHistory>
 */
class ChildStatsHistoryFactory extends Factory
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
            'child_id' => fake()->randomNumber(),
            'weight' => fake()->randomNumber(),
            'height' => fake()->randomNumber(),
        ];
    }
}

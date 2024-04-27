<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => fake()->randomNumber(),
            'doctor_id' => fake()->randomNumber(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->word(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->dateTime()
        ];
    }
}

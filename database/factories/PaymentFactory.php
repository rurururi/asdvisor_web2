<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'appointment_id' => fake()->randomNumber(),
            'doctor_id' => fake()->randomNumber(),
            'image' => fake()->file(),
            'ref_no' => fake()->words(),
            'amount' => fake()->randomNumber(),
        ];
    }
}

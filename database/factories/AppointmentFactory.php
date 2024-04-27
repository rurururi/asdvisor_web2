<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
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
            'doctor_schedule_id' => fake()->randomNumber(),
            'appointment_date' => fake()->dateTime(),
            'appointment_end_date' => fake()->dateTime(),
        ];
    }
}

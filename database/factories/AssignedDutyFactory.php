<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Duty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignedDuty>
 */
class AssignedDutyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'officer_id' => User::inRandomOrder()->first()?->id ?? User::factory(),   // Randomly use an existing officer or create if none exist     
            'duty_id' => Duty::inRandomOrder()->first()?->id ?? Duty::factory(),            // Randomly use an existing duty or create if none exist           
            'odts_code' => '(' . $this->faker->numberBetween(1000, 9999) . ')', // generate code like (1234)
            'is_done' => $this->faker->boolean(),
            'assigned_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random date between 1 year ago and now
            'created_at' => now(),
        ];
    }
}

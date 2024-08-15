<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->email(),
            'phone' => fake()->e164PhoneNumber(),
            'image' => fake()->imageUrl(),
            'registration_timestamp' => fake()->dateTime(),
            'position_id' => Position::all()->random()->id,

        ];
    }
}

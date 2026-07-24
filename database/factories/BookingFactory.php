<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reference' => 'BK-'.fake()->unique()->numerify('######'),
            'title' => fake()->randomElement([
                'Architecture review',
                'Security workshop',
                'Incident retrospective',
            ]),
            'starts_at' => fake()->dateTimeBetween('+1 day', '+30 days'),
            'status' => 'confirmed',
            'private_notes' => fake()->sentence(),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $alice = User::factory()->create([
            'name' => 'Alice Demo',
            'email' => 'alice@example.test',
        ]);

        $bob = User::factory()->create([
            'name' => 'Bob Demo',
            'email' => 'bob@example.test',
        ]);

        Booking::factory()->for($alice)->create([
            'reference' => 'BK-100001',
            'title' => 'Security architecture review',
            'private_notes' => 'Synthetic participant notes for the masterclass.',
        ]);

        Booking::factory()->for($bob)->create([
            'reference' => 'BK-100002',
            'title' => 'Incident retrospective',
            'private_notes' => 'Synthetic notes that Alice must never receive.',
        ]);
    }
}

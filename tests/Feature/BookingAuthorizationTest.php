<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_unauthenticated_user_cannot_read_a_booking(): void
    {
        $booking = Booking::factory()->create();

        $this->getJson("/api/bookings/{$booking->id}")
            ->assertUnauthorized();
    }

    public function test_an_owner_can_read_their_booking_without_private_notes(): void
    {
        $owner = User::factory()->create();
        $booking = Booking::factory()->for($owner)->create([
            'reference' => 'BK-OWNER',
            'private_notes' => 'Never serialize this field.',
        ]);

        Sanctum::actingAs($owner);

        $this->getJson("/api/bookings/{$booking->id}")
            ->assertOk()
            ->assertJsonPath('data.reference', 'BK-OWNER')
            ->assertJsonMissing(['private_notes' => 'Never serialize this field.']);
    }

    public function test_an_authenticated_user_cannot_read_another_users_booking(): void
    {
        $alice = User::factory()->create();
        $bob = User::factory()->create();
        $bobsBooking = Booking::factory()->for($bob)->create([
            'reference' => 'BK-BOB-PRIVATE',
        ]);

        Sanctum::actingAs($alice);

        $this->getJson("/api/bookings/{$bobsBooking->id}")
            ->assertNotFound()
            ->assertJsonMissing(['reference' => 'BK-BOB-PRIVATE']);
    }

    public function test_a_missing_booking_and_someone_elses_booking_are_indistinguishable(): void
    {
        $alice = User::factory()->create();
        $bobsBooking = Booking::factory()->for(User::factory())->create();

        Sanctum::actingAs($alice);

        $otherUserResponse = $this->getJson("/api/bookings/{$bobsBooking->id}");
        $missingResponse = $this->getJson('/api/bookings/999999');

        $otherUserResponse->assertNotFound();
        $missingResponse->assertNotFound();
        $this->assertSame(
            $missingResponse->json('message'),
            $otherUserResponse->json('message'),
        );
    }
}

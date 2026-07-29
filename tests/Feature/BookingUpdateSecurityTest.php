<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingUpdateSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_owner_can_update_user_editable_fields(): void
    {
        $owner = User::factory()->create();
        $booking = Booking::factory()->for($owner)->create([
            'title' => 'Original title',
        ]);

        Sanctum::actingAs($owner);

        $this->patchJson("/api/bookings/{$booking->id}", [
            'title' => 'Updated title',
            'starts_at' => '2026-08-10T15:00:00Z',
        ])
            ->assertOk()
            ->assertJsonPath('data.title', 'Updated title');

        $booking->refresh();

        $this->assertSame('Updated title', $booking->title);
        $this->assertSame('2026-08-10T15:00:00+00:00', $booking->starts_at->toIso8601String());
    }

    public function test_an_owner_cannot_over_post_server_owned_fields(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $booking = Booking::factory()->for($owner)->create([
            'reference' => 'BK-SERVER-OWNED',
            'title' => 'Original title',
            'status' => 'pending',
            'private_notes' => 'Internal only.',
        ]);

        Sanctum::actingAs($owner);

        $this->patchJson("/api/bookings/{$booking->id}", [
            'reference' => 'BK-ATTACKER-SELECTED',
            'title' => 'Attacker-selected title',
            'user_id' => $otherUser->id,
            'status' => 'approved',
            'private_notes' => 'Overwritten',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['reference', 'user_id', 'status', 'private_notes']);

        $booking->refresh();

        $this->assertSame($owner->id, $booking->user_id);
        $this->assertSame('BK-SERVER-OWNED', $booking->reference);
        $this->assertSame('Original title', $booking->title);
        $this->assertSame('pending', $booking->status);
        $this->assertSame('Internal only.', $booking->private_notes);
    }

    public function test_a_non_owner_cannot_update_a_booking(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $booking = Booking::factory()->for($owner)->create([
            'title' => 'Owner title',
        ]);

        Sanctum::actingAs($otherUser);

        $this->patchJson("/api/bookings/{$booking->id}", [
            'title' => 'Changed by someone else',
        ])->assertNotFound();

        $this->assertSame('Owner title', $booking->fresh()->title);
    }
}

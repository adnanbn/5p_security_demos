<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Security\SecurityEventRecorder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function __construct(
        private readonly SecurityEventRecorder $events,
    ) {}

    public function show(Request $request, int $booking): JsonResponse
    {
        $actor = $request->user();
        $bookingRecord = Booking::query()->find($booking);

        if ($bookingRecord === null) {
            $this->events->authorization(
                $request,
                'denied',
                'missing',
                $actor->id,
                'booking',
                $booking,
            );

            abort(404);
        }

        $this->events->authorization(
            $request,
            'allowed',
            'authenticated',
            $actor->id,
            'booking',
            $bookingRecord->id,
        );

        return response()->json([
            'data' => [
                'id' => $bookingRecord->id,
                'reference' => $bookingRecord->reference,
                'title' => $bookingRecord->title,
                'starts_at' => $bookingRecord->starts_at->toIso8601String(),
                'status' => $bookingRecord->status,
            ],
        ]);
    }

    public function update(UpdateBookingRequest $request, int $booking): JsonResponse
    {
        $actor = $request->user();
        $ownedBooking = $actor->bookings()->find($booking);

        if ($ownedBooking === null) {
            $this->events->authorization(
                $request,
                'denied',
                'not_owned_or_missing',
                $actor->id,
                'booking',
                $booking,
            );

            abort(404);
        }

        Gate::authorize('update', $ownedBooking);

        $ownedBooking->update(
            $request->safe()->only(['title', 'starts_at']),
        );

        $this->events->authorization(
            $request,
            'allowed',
            'owner',
            $actor->id,
            'booking',
            $ownedBooking->id,
        );

        return response()->json([
            'data' => [
                'id' => $ownedBooking->id,
                'reference' => $ownedBooking->reference,
                'title' => $ownedBooking->title,
                'starts_at' => $ownedBooking->starts_at->toIso8601String(),
                'status' => $ownedBooking->status,
            ],
        ]);
    }
}

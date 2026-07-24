<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PartnerCatalogController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->whereNumber('booking');
});

Route::get('/partner/catalog', PartnerCatalogController::class)
    ->middleware(['partner.api', 'throttle:partner']);

Route::fallback(fn () => response()->json([
    'message' => 'Not found.',
], 404))->middleware('expensive.denial');

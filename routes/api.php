<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PartnerCatalogController;
use App\Http\Controllers\PartnerWebhookController;
use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->whereNumber('booking');
    Route::patch('/bookings/{booking}', [BookingController::class, 'update'])
        ->whereNumber('booking');
    Route::post('/previews', PreviewController::class)
        ->middleware('throttle:preview');
});

Route::get('/partner/catalog', PartnerCatalogController::class)
    ->middleware(['partner.api', 'throttle:partner']);

Route::post('/partner/webhooks/bookings', PartnerWebhookController::class)
    ->middleware('throttle:partner');

Route::fallback(fn () => response()->json([
    'message' => 'Not found.',
], 404))->middleware('expensive.denial');

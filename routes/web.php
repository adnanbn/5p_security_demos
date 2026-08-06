<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'name' => '5% Security Masterclass Demos',
    'repository' => 'private',
    'incidents' => [
        'cross-user booking access',
    ],
]));

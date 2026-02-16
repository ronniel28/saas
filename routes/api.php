<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working'
    ]);
});

// Route::middleware([
//     'auth:sanctum',
//     'tenant',
//     'subscription'
// ])->group(function () {

//     Route::apiResource('projects', ProjectController::class);

// });



Route::post('/register', [RegisterController::class, 'register']);
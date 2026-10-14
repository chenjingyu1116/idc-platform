<?php
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['api.token'])->group(function () {
        Route::get('/me', [ApiController::class, 'me']);
        Route::get('/services', [ApiController::class, 'services']);
        Route::get('/orders', [ApiController::class, 'orders']);
    });
    Route::post('/tokens', [TokenController::class, 'create']);
    Route::get('/tokens', [TokenController::class, 'index']);
    Route::delete('/tokens/{id}', [TokenController::class, 'destroy']);
});

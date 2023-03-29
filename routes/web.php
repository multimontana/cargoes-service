<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\Invite\InviteController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('/authorization/google')->middleware(['guest'])->name('google-auth.')->group(function () {
    Route::get('/', [GoogleAuthController::class, 'toGoogle'])->name('to-google');
    Route::get('/callback', [GoogleAuthController::class, 'callback'])->name('callback');
});

Route::prefix('authorization/google_drive')->middleware(['guest'])->name('google--drive-auth.')->group(function () {
    Route::get('/callback', [GoogleAuthController::class, 'handleProviderGoogleCallback'])->name('callback');
});


Route::get('/refresh-password', [AuthController::class, 'getResetPasswordDataAction'])->name('refresh-password');

Route::prefix('/accept')->group(function () {
    Route::get('/invite', [InviteController::class, 'acceptInviteAction'])->name('invite');
});

Route::middleware([])->group(function () {
    Route::get('/', function () {
        return response()->json([
            'message' => JsonResponse::HTTP_NOT_FOUND
        ], JsonResponse::HTTP_NOT_FOUND);
    });

    Route::get('/test', function () {
    });
});

<?php

use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\Bin\BinController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Document\DocumentController;
use App\Http\Controllers\Api\Favorite\FavoriteController;
use App\Http\Controllers\Api\Folder\FolderController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Room\RoomController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

Route::post('/authorization', [AuthController::class, 'authorizationAction']);
Route::post('/signIn', [AuthController::class, 'signInWithPasswordAction']);
Route::post('/send/email/for/reset-password', [AuthController::class, 'sendEmailForResetPasswordAction']);
Route::post('/refresh-password', [AuthController::class, 'resetPasswordAction']);


Route::group(['middleware' => 'auth:api'], function () {

    /** User Route Start */
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'userAction']);
        Route::post('/update', [UserController::class, 'updateAction']);
        Route::delete('/delete', [UserController::class, 'deleteAction']);
        Route::post('/refresh/token', [UserController::class, 'refreshTokenAction']);
        Route::put('/update/password', [UserController::class, 'updatePasswordAction']);
    });
    /** User Route End */
});

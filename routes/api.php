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

    /** Project Route Start */
    Route::prefix('/projects')->group(function () {
        Route::get('/get', [ProjectController::class, 'getProjectsAction']);
    });

    Route::prefix('project')->group(function () {
        Route::get('/get/by-project-id/{projectId}', [ProjectController::class, 'getProjectDataByIdAction']);
        Route::get('/get/members/{projectId}', [ProjectController::class, 'getProjectMembersAction']);
        Route::post('/create', [ProjectController::class, 'createAction']);
        Route::post('/update/{projectId}', [ProjectController::class, 'updateAction']);
        Route::delete('/delete/{projectId}', [ProjectController::class, 'deleteAction']);
        Route::delete('/move/to/bin/{projectId}', [ProjectController::class, 'moveToBinAction']);
        Route::post('/send/invite', [ProjectController::class, 'sendInviteAction']);
    });
    /** Project Route End */

    /** Room Route Start */
    Route::prefix('/room')->group(function () {
        Route::get('/get/by-room-id/{roomId}', [RoomController::class, 'getRoomDataByIdAction']);
        Route::post('/create', [RoomController::class, 'createAction']);
        Route::post('/update/{roomId}', [RoomController::class, 'updateAction']);
        Route::delete('/delete/{roomId}', [RoomController::class, 'deleteAction']);
        Route::delete('/move/to/bin/{roomId}', [RoomController::class, 'moveToBinAction']);
        Route::post('/send/invite', [RoomController::class, 'sendInviteAction']);
    });
    /** Room Route End */

    /** Document Route Start */
    Route::prefix('/documents')->group(function () {
        Route::get('/get', [DocumentController::class, 'getDocumentsAction']);
    });

    Route::prefix('document')->group(function () {
        Route::get('/get/by-document-id/{documentId}', [DocumentController::class, 'getDocumentByIdAction']);
        Route::post('/create', [DocumentController::class, 'createAction']);
        Route::post('/update/{documentId}', [DocumentController::class, 'updateAction']);
        Route::post('/user/update/{documentId}', [DocumentController::class, 'updateDocumentUserPermissionAction']);
        Route::post('/user/delete/{documentId}', [DocumentController::class, 'deleteDocumentUserAction']);
        Route::delete('/delete/{documentId}', [DocumentController::class, 'deleteAction']);
        Route::delete('/move/to/bin/{documentId}', [DocumentController::class, 'moveToBinAction']);
        Route::post('/send/invite', [DocumentController::class, 'sendInviteAction']);
        Route::post('/copy-link/invite', [DocumentController::class, 'inviteCopyLinkAction']);
        Route::post('/accept/copy-link/invite', [DocumentController::class, 'acceptLinkInviteAction']);
    });
    /** Document Route End */

    /** Folder Route Start */
    Route::prefix('/folders')->group(function () {
        Route::get('/get', [FolderController::class, 'getFoldersAction']);
    });

    Route::prefix('folder')->group(function () {
        Route::get('/get/by-folder-id/{folderId}', [FolderController::class, 'getFolderDataByIdAction']);
        Route::post('/create', [FolderController::class, 'createAction']);
        Route::post('/update/{folderId}', [FolderController::class, 'updateAction']);
        Route::delete('/delete/{folderId}', [FolderController::class, 'deleteAction']);
        Route::delete('/move/to/bin/{folderId}', [FolderController::class, 'moveToBinAction']);
        Route::post('/send/invite', [FolderController::class, 'sendInviteAction']);
    });
    /** Folder Route End */

    /** Start Dashboard Route */
    Route::prefix('dashboard')->group(function () {
        Route::get('/get/data', [DashboardController::class, 'getDashboardDataAction']);
    });

    /** End Dashboard Route */

    /** Start Bin Route */
    Route::prefix('bin')->group(function () {
        Route::get('/get', [BinController::class, 'getBinDataAction']);
        Route::delete('/delete/all', [BinController::class, 'deleteBinDataAction']);
        Route::post('/restore', [BinController::class, 'restoreBinDataAction']);
        Route::post('/restore/single/entities', [BinController::class, 'restoreSingleEntitiesInBinAction']);
    });
    /** End Bin Route */

    /** Start Favorite Route */
    Route::prefix('favorites')->group(function () {
        Route::get('/get', [FavoriteController::class, 'getFavoritesAction']);
    });

    Route::prefix('favorite')->group(function () {
        Route::post('/add', [FavoriteController::class, 'addAction']);
        Route::post('/restore/all', [FavoriteController::class, 'restoreAllAction']);
        Route::post('/restore/by-entities', [FavoriteController::class, 'restoreSingleEntitiesInFavoriteAction']);
    });
    /** End Favorite Route */

    /** Start Location Route */

    Route::prefix('/countries')->group(function () {
        Route::get('/get', [UserController::class, 'getCountriesAction']);
    });

    /** End Location Route */

    Route::post('/logout', [AuthController::class, 'logoutAction']);

    /**  google doc */
    Route::prefix('/google-drive')->group(function () {
        Route::get('/files', [GoogleAuthController::class, 'googleDriveFiles']);
        Route::post('/file/export', [GoogleAuthController::class, 'googleDriveFileExport']);
    });
});

Route::prefix('/accept')->group(function () {
    Route::get('/project/invite', [ProjectController::class, 'acceptInviteAction'])->name('project');
    Route::get('/project/room/invite', [ProjectController::class, 'acceptInviteAction'])->name('project-room');
    Route::get('/document/invite', [DocumentController::class, 'acceptInviteAction'])->name('document');
    Route::get('/folder/invite', [FolderController::class, 'acceptInviteAction'])->name('folder');
});
Route::prefix('dashboard/pages')->group(function () {
    Route::post('/how-to-rescript/create', [DashboardController::class, 'createHowToRescriptPageDataAction']);
    Route::get('/how-to-rescript', [DashboardController::class, 'getHowToRescriptPageDataAction']);
});


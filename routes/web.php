<?php

use App\Http\Controllers\CurseController;
use App\Http\Controllers\MissionAssignmentController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\SorcererController;
use App\Models\Mission;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mailable', function () {
    $mission = Mission::find(1);
    return new App\Mail\MissionAssignedMail($mission, 'Sorcerer', 1);
});

Route::prefix('/mission')->group(function () {
    Route::get('/', [MissionController::class, 'index']);
    Route::post('/generate', [MissionController::class, 'generate']);
    Route::get('/unassigned', [MissionController::class, 'unassigned']);
    Route::get('/{id}', [MissionController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/{id}/send-email', [MissionController::class, 'sendEmail'])->where('id', '[0-9]+');
});

Route::prefix('/sorcerer')->group(function () {
    Route::get('/', [SorcererController::class, 'index']);
    Route::get('/{id}', [SorcererController::class, 'show'])->where('id', '[0-9]+');
});

Route::prefix('/curse')->group(function () {
    Route::get('/', [CurseController::class, 'index']);
    Route::get('/{id}', [CurseController::class, 'show'])->where('id', '[0-9]+');
});

Route::prefix('/assignment')->group(function () {
    Route::get('/', [MissionAssignmentController::class, 'index']);
    Route::get('/{id}', [MissionAssignmentController::class, 'show'])->where('id', '[0-9]+');
});

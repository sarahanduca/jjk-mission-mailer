<?php

use App\Http\Controllers\MissionController;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/mailable', function () {
    $mission = App\Models\Mission::find(1);

    return new App\Mail\MissionAssignedMail($mission, 'Feiticeiro', 1);
});

Route::prefix('/mission')->group(function () {
    Route::post('/assign', [MissionController::class, 'store']);
    Route::get('/{id}', [MissionController::class, 'getMission']);
    Route::get('/index', [MissionController::class, 'index']);
    Route::post('/{mission}/accept', function (Mission $mission, Request $request) {
        $userId = $request->query('user_id');
        return response()->json(['message' => 'Missão aceita com sucesso!']);
    });
    Route::post('/{mission}/decline', function (Mission $mission, Request $request) {
        $userId = $request->query('user_id');
        return response()->json(['message' => 'Missão recusada.']);
    });

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//イベント登録
Route::post('/schedule-add', [ScheduleController::class, 'scheduleAdd']);

//イベント取得
Route::post('/schedule-get', [ScheduleController::class, 'scheduleGet']);

//イベント更新
Route::post('/schedule-update', [ScheduleController::class, 'scheduleUpdate']);

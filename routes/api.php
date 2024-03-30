<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\MatchStatisticsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PlayerStatisticsController;
use App\Http\Controllers\TeamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login',[AuthController::class,'login'])->name('api.login');
Route::post('/register',[AuthController::class,'register'])->name('api.register');
Route::post('/forgotPassword',[AuthController::class,'forgotPassword'])->name('api.forgotPassword');
Route::post('/logout',[AuthController::class,'logout'])->name('api.logout');
Route::apiResource('players', PlayersController::class);
Route::apiResource('matches', MatchesController::class);
Route::apiResource('teams', TeamsController::class);
Route::apiResource('player-statistics', PlayerStatisticsController::class);
Route::apiResource('match-statistics', MatchStatisticsController::class);
Route::apiResource('notifications', NotificationsController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

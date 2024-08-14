<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'index']);

Route::get('/check-league-client', [ProcessController::class, 'getClientStatus']);
Route::get('/summoner-info', [ProcessController::class, 'getSummonerInfo']);
Route::get('/set-background/{skinId}', [ProcessController::class, 'setBackgroundImage'])->name('set-background');
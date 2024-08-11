<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-league-client', [ProcessController::class, 'getClientStatus']);
Route::get('/summoner-info', [ProcessController::class, 'getSummonerInfo']);
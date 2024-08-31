<?php

use App\Http\Controllers\Api\ExcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('users', ExcelController::class)->only(['store']);

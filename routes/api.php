<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/me', [AuthenticationController::class, 'me']);

    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::patch('/recipes/{id}', [RecipeController::class, 'update'])->middleware('recipe.owner');
});

Route::post('/login', [AuthenticationController::class, 'login']);

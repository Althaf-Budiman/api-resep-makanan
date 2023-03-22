<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::patch('/recipes/{id}', [RecipeController::class, 'update'])->middleware('recipe.owner');
    Route::delete('/recipes/{id}', [RecipeController::class, 'delete'])->middleware('recipe.owner');

    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/me', [AuthenticationController::class, 'me']);

    Route::post('/recipes', [RecipeController::class, 'store']);

    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('comment.owner');
});

Route::post('/login', [AuthenticationController::class, 'login']);

<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FavController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
Route::get('/users', [UserController::class, 'allUsers']);
Route::get('/user', [UserController::class, 'getUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
Route::put('/users/{id}/type', [UserController::class, 'updateRole']);
    });



     Route::post('/register', [AuthController::class, 'register']);
     Route::post('/login', [AuthController::class, 'login']);
     Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('courses/{courseId}/card', [CardController::class, 'addToCard']);
    Route::get('users/card', [CardController::class, 'getItems']);
    Route::delete('/card/{cardId}', [CardController::class, 'removeFromCard']);
});

Route::middleware('auth:sanctum')->group(function () {
     Route::post('courses/favorite/{courseId}', [FavController::class, 'toggleFavorite']);
     Route::get('users/favorites', [FavController::class, 'getFavorites']);
    });

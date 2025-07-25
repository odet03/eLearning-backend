<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FavController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
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

Route::middleware('auth:sanctum')->group(function () {
Route::get('courses', [CourseController::class, 'index']);         // List all courses
Route::get('courses/{id}', [CourseController::class, 'show']);     // Get a single course
Route::post('courses', [CourseController::class, 'store']);        // Create a new course
Route::put('courses/{id}', [CourseController::class, 'update']);   // Update a course
Route::delete('courses/{id}', [CourseController::class, 'destroy']); // Delete a course
});

Route::middleware('auth:sanctum')->group(function () {
Route::get('lessons', [LessonController::class, 'index']);         // List all lessons
Route::get('lessons/{id}', [LessonController::class, 'show']);     // Get a single lesson
Route::post('lessons', [LessonController::class, 'store']);        // Create a new lesson
Route::put('lessons/{id}', [LessonController::class, 'update']);   // Update a lesson
Route::delete('lessons/{id}', [LessonController::class, 'destroy']);// Delete a lesson
  });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index']);         // List all categories
    Route::get('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'show']);     // Get a single category
    Route::post('categories', [\App\Http\Controllers\CategoryController::class, 'store']);        // Create a new category
    Route::put('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);   // Update a category
    Route::delete('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy']); // Delete a category
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('ratings', [\App\Http\Controllers\RatingController::class, 'index']);         // List all ratings
    Route::get('ratings/{id}', [\App\Http\Controllers\RatingController::class, 'show']);     // Get a single rating
    Route::post('ratings', [\App\Http\Controllers\RatingController::class, 'store']);        // Create a new rating
    Route::put('ratings/{id}', [\App\Http\Controllers\RatingController::class, 'update']);   // Update a rating
    Route::delete('ratings/{id}', [\App\Http\Controllers\RatingController::class, 'destroy']); // Delete a rating
    Route::get('courses/{courseId}/count_rating', [\App\Http\Controllers\RatingController::class, 'countRating']); // Get rating count for a course
    Route::get('courses/{courseId}/average-rating', [\App\Http\Controllers\RatingController::class, 'averageRating']); // Get average rating for a course
});
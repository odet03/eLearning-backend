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
//Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
//Route::middleware('auth:sanctum')->post('/email/resend', [AuthController::class, 'resendVerificationEmail']);
//Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink']);
//Route::post('/password/reset/{token}', [AuthController::class, 'resetPassword']);

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
Route::get('courses-count', [CourseController::class, 'count']);   // Get total number of courses
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


Route::middleware('auth:sanctum')->group(function () {
    // Enrollments CRUD
    Route::get('enrollments', [\App\Http\Controllers\EnrollmentsController::class, 'index']);
    Route::get('enrollments/{id}', [\App\Http\Controllers\EnrollmentsController::class, 'show']);
    Route::post('enrollments', [\App\Http\Controllers\EnrollmentsController::class, 'store']);
    Route::put('enrollments/{id}', [\App\Http\Controllers\EnrollmentsController::class, 'update']);
    Route::delete('enrollments/{id}', [\App\Http\Controllers\EnrollmentsController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    // Progress CRUD
    Route::get('progress', [\App\Http\Controllers\ProgressController::class, 'index']);
    Route::get('progress/{id}', [\App\Http\Controllers\ProgressController::class, 'show']);
    Route::post('progress', [\App\Http\Controllers\ProgressController::class, 'store']);
    Route::put('progress/{id}', [\App\Http\Controllers\ProgressController::class, 'update']);
    Route::delete('progress/{id}', [\App\Http\Controllers\ProgressController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function () {
    // Quiz CRUD
    Route::get('quizzes', [\App\Http\Controllers\QuizController::class, 'index']);
    Route::get('quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'show']);
    Route::post('quizzes', [\App\Http\Controllers\QuizController::class, 'store']);
    Route::put('quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'update']);
    Route::delete('quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'destroy']);

    // Additional quiz endpoints
    Route::get('quizzes/{id}/with-questions', [\App\Http\Controllers\QuizController::class, 'getQuizWithQuestions']);
    Route::get('courses/{courseId}/quizzes', [\App\Http\Controllers\QuizController::class, 'getQuizzesByCourse']);
    Route::get('quizzes/{id}/stats', [\App\Http\Controllers\QuizController::class, 'getQuizStats']);
    Route::get('quizzes/{id}/completion', [\App\Http\Controllers\QuizController::class, 'checkQuizCompletion']);
});

Route::middleware('auth:sanctum')->group(function () {
    // QuizQuestion CRUD
    Route::get('quiz-questions', [\App\Http\Controllers\QuizQuestionController::class, 'index']);
    Route::get('quiz-questions/{id}', [\App\Http\Controllers\QuizQuestionController::class, 'show']);
    Route::post('quiz-questions', [\App\Http\Controllers\QuizQuestionController::class, 'store']);
    Route::put('quiz-questions/{id}', [\App\Http\Controllers\QuizQuestionController::class, 'update']);
    Route::delete('quiz-questions/{id}', [\App\Http\Controllers\QuizQuestionController::class, 'destroy']);

    // Additional quiz question endpoints
    Route::get('quizzes/{quizId}/questions', [\App\Http\Controllers\QuizQuestionController::class, 'getQuestionsByQuiz']);
    Route::get('quizzes/{quizId}/questions-for-student', [\App\Http\Controllers\QuizQuestionController::class, 'getQuestionsForStudent']);
    Route::post('quiz-questions/bulk', [\App\Http\Controllers\QuizQuestionController::class, 'bulkStore']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Quiz Results CRUD
    Route::post('quiz-results', [\App\Http\Controllers\QuizResultController::class, 'store']);
    Route::get('quiz-results', [\App\Http\Controllers\QuizResultController::class, 'index']);
    Route::get('quiz-results/{id}', [\App\Http\Controllers\QuizResultController::class, 'show']);
    Route::get('quizzes/{quizId}/all-results', [\App\Http\Controllers\QuizResultController::class, 'getAllQuizResults']);
});

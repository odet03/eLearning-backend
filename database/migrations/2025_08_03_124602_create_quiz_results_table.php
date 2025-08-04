<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->decimal('score', 5, 2); // Quiz score (e.g., 85.50)
            $table->integer('total_questions'); // Total number of questions in the quiz
            $table->integer('correct_answers'); // Number of correct answers
            $table->integer('time_taken')->nullable(); // Time taken in seconds (optional)
            $table->timestamp('completed_at');
            $table->timestamps();
            
            // Ensure a user can only have one result per quiz
            $table->unique(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

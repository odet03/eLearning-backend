<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('progress', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
                $table->foreignId('quiz_id')->nullable()->constrained('quizzs')->onDelete('cascade');
                $table->decimal('mark', 5, 2)->nullable();
                $table->enum('status', ['not_started', 'completed', 'in-progress'])->default('not_started');
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};

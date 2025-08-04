<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        return response()->json(Quiz::all());
    }

    public function show($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        return response()->json($quiz);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
        ]);
        $quiz = Quiz::create($validated);
        return response()->json($quiz, 201);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        $validated = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'title' => 'sometimes|required|string|max:255',
        ]);
        $quiz->update($validated);
        return response()->json($quiz);
    }

    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted']);
    }

    /**
     * Get quiz with questions
     */
    public function getQuizWithQuestions($id)
    {
        $quiz = Quiz::with('questions')->find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        return response()->json($quiz);
    }

    /**
     * Get quizzes for a specific course
     */
    public function getQuizzesByCourse($courseId)
    {
        $quizzes = Quiz::where('course_id', $courseId)->get();
        return response()->json($quizzes);
    }

    /**
     * Get quiz statistics (for teachers/admins)
     */
    public function getQuizStats($id)
    {
        $user = Auth::user();
        
        // Check if user is teacher or admin
        if (!in_array($user->role, ['teacher', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $results = QuizResult::where('quiz_id', $id)->get();
        
        $stats = [
            'total_attempts' => $results->count(),
            'average_score' => $results->count() > 0 ? round($results->avg('score'), 2) : 0,
            'highest_score' => $results->count() > 0 ? $results->max('score') : 0,
            'lowest_score' => $results->count() > 0 ? $results->min('score') : 0,
            'passing_rate' => $results->count() > 0 ? round(($results->where('score', '>=', 60)->count() / $results->count()) * 100, 2) : 0,
        ];

        return response()->json($stats);
    }

    /**
     * Check if user has completed a quiz
     */
    public function checkQuizCompletion($id)
    {
        $user = Auth::user();
        $quiz = Quiz::find($id);
        
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $result = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $id)
            ->first();

        return response()->json([
            'completed' => $result ? true : false,
            'result' => $result
        ]);
    }
} 
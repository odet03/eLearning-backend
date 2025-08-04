<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizResultController extends Controller
{
    /**
     * Store a new quiz result
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|numeric|min:0|max:100',
            'total_questions' => 'required|integer|min:1',
            'correct_answers' => 'required|integer|min:0',
            'time_taken' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();

        // Check if user already has a result for this quiz
        $existingResult = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $request->quiz_id)
            ->first();

        if ($existingResult) {
            return response()->json([
                'message' => 'You have already completed this quiz',
                'result' => $existingResult
            ], 409);
        }

        $result = QuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $request->quiz_id,
            'score' => $request->score,
            'total_questions' => $request->total_questions,
            'correct_answers' => $request->correct_answers,
            'time_taken' => $request->time_taken,
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Quiz result saved successfully',
            'result' => $result
        ], 201);
    }

    /**
     * Get quiz results for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $results = QuizResult::with('quiz')
            ->where('user_id', $user->id)
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json($results);
    }

    /**
     * Get a specific quiz result
     */
    public function show($id)
    {
        $user = Auth::user();
        $result = QuizResult::with('quiz')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return response()->json($result);
    }

  

    /**
     * Get all results for a specific quiz (for teachers/admins)
     */
    public function getAllQuizResults($quizId)
    {
        $user = Auth::user();

        // Check if user is teacher or admin
        if (!in_array($user->role, ['teacher', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $results = QuizResult::with('user')
            ->where('quiz_id', $quizId)
            ->orderBy('score', 'desc')
            ->get();

        return response()->json($results);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    public function index()
    {
        return response()->json(QuizQuestion::all());
    }

    public function show($id)
    {
        $question = QuizQuestion::find($id);
        if (!$question) {
            return response()->json(['message' => 'Quiz question not found'], 404);
        }
        return response()->json($question);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string',
        ]);
        $question = QuizQuestion::create($validated);
        return response()->json($question, 201);
    }

    public function update(Request $request, $id)
    {
        $question = QuizQuestion::find($id);
        if (!$question) {
            return response()->json(['message' => 'Quiz question not found'], 404);
        }
        $validated = $request->validate([
            'quiz_id' => 'sometimes|required|exists:quizzes,id',
            'question' => 'sometimes|required|string',
            'options' => 'sometimes|required|array|min:2',
            'correct_answer' => 'sometimes|required|string',
        ]);
        $question->update($validated);
        return response()->json($question);
    }

    public function destroy($id)
    {
        $question = QuizQuestion::find($id);
        if (!$question) {
            return response()->json(['message' => 'Quiz question not found'], 404);
        }
        $question->delete();
        return response()->json(['message' => 'Quiz question deleted']);
    }

    /**
     * Get questions for a specific quiz
     */
    public function getQuestionsByQuiz($quizId)
    {
        $questions = QuizQuestion::where('quiz_id', $quizId)->get();
        return response()->json($questions);
    }

    /**
     * Get questions for a specific quiz (without correct answers for students)
     */
    public function getQuestionsForStudent($quizId)
    {
        $questions = QuizQuestion::where('quiz_id', $quizId)
            ->select('id', 'quiz_id', 'question', 'options')
            ->get();
        
        return response()->json($questions);
    }

    /**
     * Bulk create questions for a quiz
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $questions = [];
        foreach ($request->questions as $questionData) {
            $questions[] = QuizQuestion::create([
                'quiz_id' => $request->quiz_id,
                'question' => $questionData['question'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return response()->json([
            'message' => 'Questions created successfully',
            'questions' => $questions
        ], 201);
    }
} 
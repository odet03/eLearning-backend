<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        return response()->json(Rating::all());
    }

    public function show($id)
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }
        return response()->json($rating);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);
        $userId = Auth::id();
        $existing = Rating::where('user_id', $userId)
            ->where('course_id', $validated['course_id'])
            ->first();
        if ($existing) {
            return response()->json(['message' => 'You have already rated this course.'], 409);
        }
        $validated['user_id'] = $userId;
        $rating = Rating::create($validated);
        return response()->json($rating, 201);
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }
        $validated = $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);
        $rating->update($validated);
        return response()->json($rating);
    }

    public function destroy($id)
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }
        $rating->delete();
        return response()->json(['message' => 'Rating deleted']);
    }

    public function countRating($courseId)
    {
        $count = Rating::where('course_id', $courseId)->count();

        return response()->json([
            'course_id' => $courseId,
            'rating_count' => $count,

        ]);
    }

    public function averageRating($courseId)
    {
        $average = Rating::where('course_id', $courseId)->avg('rating');
        return response()->json([
            'course_id' => $courseId,
            'average_rating' => $average ? round($average, 2) : null,
        ]);
    }
}
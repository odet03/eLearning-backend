<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        return response()->json(Lesson::all());
    }

    public function show($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }
        return response()->json($lesson);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id', // Ensure the course exists
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'nullable|integer',
            'video_duration' => 'nullable|string',

        ]);
        $lesson = Lesson::create($validated);
        return response()->json($lesson, 201);
    }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404); // Return 404 if lesson is not found
        }
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'nullable|integer',
            'video_duration' => 'nullable|string',
            'type' => 'sometimes|required|in:lesson,quiz',
        ]);
        $lesson->update($validated);
        return response()->json($lesson, 200);
    }


    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }
        $lesson->delete();
        return response()->json(['message' => 'Lesson deleted']);
    }
}
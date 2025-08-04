<?php

namespace App\Http\Controllers;

use App\Models\Enrollments;
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{
    public function index()
    {
        return response()->json(Enrollments::all());
    }

    public function show($id)
    {
        $enrollment = Enrollments::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }
        return response()->json($enrollment);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);
        $exists = Enrollments::where('user_id', $validated['user_id'])
            ->where('course_id', $validated['course_id'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'You are already enrolled.'], 409);
        }
        $enrollment = Enrollments::create($validated);
        return response()->json($enrollment, 201);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollments::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'course_id' => 'sometimes|required|exists:courses,id',
        ]);
        $enrollment->update($validated);
        return response()->json($enrollment);
    }

    public function destroy($id)
    {
        $enrollment = Enrollments::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }
        $enrollment->delete();
        return response()->json(['message' => 'Enrollment deleted']);
    }
} 
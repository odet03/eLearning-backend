<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index()
    {
        return response()->json(Progress::all());
    }

    public function show($id)
    {
        $progress = Progress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }
        return response()->json($progress);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
            'completed' => 'required|boolean',
        ]);
        $progress = Progress::create($validated);
        return response()->json($progress, 201);
    }

    public function update(Request $request, $id)
    {
        $progress = Progress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'lesson_id' => 'sometimes|required|exists:lessons,id',
            'completed' => 'sometimes|required|boolean',
        ]);
        $progress->update($validated);
        return response()->json($progress);
    }

    public function destroy($id)
    {
        $progress = Progress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }
        $progress->delete();
        return response()->json(['message' => 'Progress deleted']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class FavController extends Controller
{
   public function toggleFavorite(Request $request, $courseId)
    {
        $user = Auth::user();
        $favorite = Favourite::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Course removed from favorite'], 200);
        } else {
            $course = Course::find($courseId);

            if (!$course) {
                return response()->json(['message' => 'Course not found'], 404);
            }

            Favourite::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
            ]);

            return response()->json(['message' => 'Course added to favorite'], 201);
        }
    }
    public function getFavorites()
    {
        $user = Auth::user();
        $favorites = Favourite::where('user_id', $user->id)
            ->with('course')
            ->get()
            ->map(function ($favorites) {
                return $favorites->course;
            });

        return response()->json($favorites, 200);
    }
}
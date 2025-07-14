<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller

//Add a course to the user's card.
{
    public function addToCard(Request $request, $courseId)
    {
        $user = Auth::user();
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $cardItem = Card::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($cardItem) {
            return response()->json(['message' => 'Course already in Card'], 400);
        }

        $cardItem = Card::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'quantity' => 1
        ]);

        return response()->json(['message' => 'Course added to card', 'cardItem' => $cardItem], 201);
    }

    public function getItems()
    {

        $cardItem = Card::where('user_id', Auth::id())
            ->with('Course')
            ->get()
            ->map(function ($cardItem) {
                return [
                    'card_id' => $cardItem->id,
                    'course' => $cardItem->course
                ];
            });

        return response()->json($cardItem, 200);
    }
    public function removeFromCard($CardId)
    {
        $user = Auth::user();
        $cardItem = Card::where('id', $CardId)->where('user_id', $user->id)->first();

        if (!$cardItem) {
            return response()->json(['message' => 'Card item not found'], 404);
        }

        $cardItem->delete();

        return response()->json(['message' => 'Card item removed'], 200);
    }
}

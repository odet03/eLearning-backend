<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Return authenticated user
    public function getUser(Request $request)
    {
        return response()->json(Auth::user());
    }

    // Get all users
    public function allUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    // delete a user
    public function deleteUser($id)
    {
        $authenticatedUser = Auth::user();
        $user = User::find($id);
        if ($authenticatedUser->role !== "admin") {
            return response()->json(['message' => 'Forbidden'], 403);
        }
      //  $user->cards()->delete();
        //$user->enrollments()->delete();
       // $user->progress()->delete();

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }


    // Update user role
    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'role' => 'required|in:student,teacher,admin',
        ]);
        $user->role = $request->input('role');
        $user->save();
        return response()->json(['message' => 'Role updated successfully', 'user' => $user], 200);
    }
}

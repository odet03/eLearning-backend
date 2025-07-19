<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'      => 'required|string|max:255',
            'lastName'      => 'required|string|max:255',
            'email'     => 'required|string|max:255|unique:users',
            'password'  => 'required|string',
            'phoneNumber'  => 'required|string',
            'role' => 'nullable|in:student,teacher,admin',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
            $user = User::create([
                'firstName'      => $request->firstName,
                'lastName'      => $request->lastName,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phoneNumber'  => $request->phoneNumber,
                'role' => $request->role ?? 'student',
            ]);


            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user'          => $user,
                'access_token'  => $token,
                'token_type'    => 'Bearer'
            ]);

    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials    =   $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }
        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'          => $user,
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfull'
        ]);
    }
}

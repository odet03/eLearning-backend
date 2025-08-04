<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            // Send verification email
            //$this->sendVerificationEmail($user);

            return response()->json([
                'user'          => $user,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'message'       => 'Registration successful. Please verify your email.'
            ]);

    }

    /**protected function sendVerificationEmail($user)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        Mail::raw('Click here to verify your email: ' . $verificationUrl, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify Email Address');
        });
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->email))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }
        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified.']);
        }
        $user->email_verified_at = now();
        $user->save();
        return response()->json(['message' => 'Email verified successfully.']);
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = $request->user();
        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified.']);
        }
        $this->sendVerificationEmail($user);
        return response()->json(['message' => 'Verification email resent.']);
    }**/


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


/*
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'If your email exists in our system, you will receive a password reset link.'], 200);
        }
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );
        $resetUrl = url('/api/password/reset/' . $token . '?email=' . urlencode($user->email));
        Mail::raw('Click here to reset your password: ' . $resetUrl, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password');
        });
        return response()->json(['message' => 'If your email exists in our system, you will receive a password reset link.'], 200);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
        ]);
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $token)
            ->first();
        if (!$record) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json(['message' => 'Password reset successful.']);
    }*/
}

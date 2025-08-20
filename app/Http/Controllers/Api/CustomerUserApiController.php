<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerUserApiController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customer_users,email',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'username' => 'required|string|unique:customer_users,username',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Create user
        $user = CustomerUser::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'customer', // default role
        ]);

        // Create Sanctum API token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = CustomerUser::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Get profile for authenticated user
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // Update profile
   public function update(Request $request)
{
    $user = $request->user();

    $request->validate([
        'full_name' => 'sometimes|string|max:255',
        'phone_number' => 'sometimes|string|max:20',
        'gender' => 'sometimes|in:Male,Female,Other',
        'profile_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // validate image
    ]);

    // Update text fields
    $user->update($request->only(['full_name','phone_number','gender']));

    // Handle profile image if uploaded
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $filename = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads/profile_images'), $filename);
        $user->profile_image = 'uploads/profile_images/'.$filename;
        $user->save();
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'user' => $user,
    ]);
}
    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }
}

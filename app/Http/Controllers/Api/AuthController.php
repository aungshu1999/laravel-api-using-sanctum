<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Step 1: Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Step 2: Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Step 3: Assign Default Role
        $role = Role::where('slug', 'user')->firstOrFail();

        $user->roles()->attach($role->id);

        // Step 4: Generate Token
        $token = $user->createToken('api-token')->plainTextToken;

        // Step 5: Return Response
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user->load('roles'),
            'token' => $token,
        ], 201);
    }
    
public function login(Request $request)
{
    // Step 1: Validate request data
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Step 2: Find user by email
    $user = User::where('email', $validated['email'])->first();

    // Step 3: Verify user and password
    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    // Step 4: Generate Sanctum token
    $token = $user->createToken('api-token')->plainTextToken;

    // Step 5: Return response
    return response()->json([
        'message' => 'Login successful',
        'user' => $user->load('roles'),
        'token' => $token,
    ], 200);
}
public function logout(Request $request)
{
    // Delete current access token
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout successful'
    ], 200);
}

private function teting()
{
    echo "changed by mondal";
}

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,manager',
        ]);

        // Find requested role
        $role = Role::where('slug', $validated['role'])
            ->firstOrFail();

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign role to user
        $user->roles()->attach($role->id);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->load('roles'),
        ], 201);
    }

   public function getUsers(Request $request)
    {
        $user = $request->user()->load('roles');

        return response()->json([
            'message' => 'User details fetched successfully',
            'user' => $user
        ], 200);
    }
}
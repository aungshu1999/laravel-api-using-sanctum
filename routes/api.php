<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

Route::post('/logout', [AuthController::class, 'logout']);

});
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return response()->json([
            'message' => 'Welcome Admin'
        ]);
    });
 Route::post('/users', [UserController::class, 'store']);


});
Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return response()->json([
            'message' => 'Welcome Manager'
        ]);
    });

});
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [UserController::class, 'getUsers']);

});


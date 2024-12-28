<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function dashboard()
    {
        return "Hello Form User Dashboard";
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'skills' => 'nullable|array',
            'skills.*.name' => 'required|string|max:100',
            'skills.*.description' => 'nullable|string|max:255',
        ]);

        try {
            $user = $this->userService->updateUserProfile($request->all(), $request->header('id'));
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function feed(Request $request)
    {
        $userId = $request->header('id');
        return $this->userService->getFeed($userId);
    }
}

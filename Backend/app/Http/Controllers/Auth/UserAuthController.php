<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\JWTToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    // Register Method This Method Receive Post Request
    public function register(Request $request)
    {
        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            return response()->json([
                'status' => 'success',
                'massage' => 'Registation Successfully!'
            ]);
        } catch (Exceptions $e) {
            return response()->json([
                'status' => 'error',
                'massage' => 'Registation Faild!'
            ]);
        }
    }
    // Login Method This Method Receive Post Request
    public function login(Request $request)
    {
        $check = User::where('email', $request->input())->first();
        if ($check && Hash::check($request->input('password'), $check->password)) {
            if ($check !== null) {
                $token = JWTToken::CreateToken($check->email, $check->id, $check->role);
                return response()->json([
                    'status' => 'success',
                    'massage' => 'Login Successful',
                    'token' => $token
                ], 200)->cookie('token', $token, time() + 60 * 24 * 38);
            } else {
                return response()->json([
                    'status' => 'error',
                    'massage' => 'Login Failed. Invalid credentials.',
                ], 401);
            }
        }
    }
    // Logout Method This Method Receive Get Request
    public function logout()
    {
        return redirect('user-login')->cookie('token', '', -1);
    }
}

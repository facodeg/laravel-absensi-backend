<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        $loginDate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $loginDate['email'])->first();

        //check user exist
        if (!$user) {
            return response(
                [
                    'message' => 'User not found',
                ],
                401,
            );
        }

        //check password
        if (!Hash::check($loginDate['password'], $user->password)) {
            return response()(
                [
                    'message' => 'Password not match',
                ],
                401,
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(
            [
                'user' => $user,
                'token' => $token,
            ],
            200,
        );
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(
            [
                'message' => 'Logout success',
            ],
            200,
        );
    }
}

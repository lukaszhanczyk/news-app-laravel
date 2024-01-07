<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(SignupRequest $request): Response
    {
        $data = $request->validated();

        $user = new UserResource(User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]));

        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function login(LoginRequest $request): Response
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response([
                'message' => 'Provided email or password are not valid'
            ], 422);
        }

        /* @var User $user*/
        $user = new UserResource(Auth::user());
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function logout(): Response
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'message' => 'Logged out successfully!',
            'status_code' => 200
        ], 200);
    }
}

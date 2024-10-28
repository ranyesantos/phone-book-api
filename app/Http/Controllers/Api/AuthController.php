<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function store(AuthRequest $request): JsonResponse
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'usuário cadastrado com sucesso'
        ], 200);


    }

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user
            ], 201);

        } else {

            return response()->json([
                'status' => false,
                'message' => "credenciais incorretas"
            ], 401);


        }
    }
    public function logout(User $user)
    {

        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => "o usuário foi deslogado"
        ], 200);

    }
}

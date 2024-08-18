<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function store(Request $request): Response
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response(200);


    }

    public function login(Request $request): Response
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password
        ])){

            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

                $response = [
                    'token' => $token
                ];
                return response($response);

        } else {

            $response = [
                'message' => "credenciais incorretas"
            ];
            return response($response);

        }
    }

}

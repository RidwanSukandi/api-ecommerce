<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return response()->json([
            'data' => [
                "id" => $user->id,
                "username" => $user->username,
                "address" => $user->address,
                "token" => $user->token
            ]
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        User::where('token', $user['token'])
            ->update([
                "token" => null
            ]);

        return response()->json([
            "message" => "success"
        ])->setStatusCode(200);
    }
}

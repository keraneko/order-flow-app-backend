<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        // 認証が失敗の場合
        if(!Auth::attempt($credentials)){
        
        return response()->json([
            'message' => '認証情報が正しくありません'
        ],401);
        }

        $request->session()->regenerate();

        $user = $request->user();

        return response()->json([
            'user' => $user
        ]);

    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
	public function getToken()
	{
        $randomString = Str::random(276);

        Token::truncate();;
        $token = Token::create([
            'token' => $randomString,
            'expires_at' => Carbon::now()->addMinutes(40),
        ]);

        return response()->json([
            'success' => true,
            'token' => $token->token,
        ]);
	}
}

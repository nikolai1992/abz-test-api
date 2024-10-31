<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TokenController extends Controller
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

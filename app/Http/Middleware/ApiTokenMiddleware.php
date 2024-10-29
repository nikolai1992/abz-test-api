<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $requestApiToken = $request->header('Token');
        $apiToken = Token::first();
        if ($apiToken) {
            if ($apiToken->expires_at > Carbon::now()) {
                if ($requestApiToken === $apiToken->token) {
                    return $next($request);
                }
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid token. Try to get a new one by the method GET api/v1/token.',
        ], 401);
    }
}

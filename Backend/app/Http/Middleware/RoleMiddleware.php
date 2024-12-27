<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $token = $request->bearerToken(); // Get token from the Authorization header
        $decoded = JWTToken::VerifyToken($token, $role);

        if (is_string($decoded)) { // Unauthorized message returned
            return response()->json(['error' => $decoded], 403);
        } else {
            $request->headers->set('email', $decoded->UserEmail);
            $request->headers->set('id', $decoded->userId);
            // Proceed with request
            return $next($request);
        }
    }
}

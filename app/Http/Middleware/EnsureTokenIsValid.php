<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request has a valid token
        if ($request->header('Authorization') !== 'Bearer '. env('API_TOKEN')) {

            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}

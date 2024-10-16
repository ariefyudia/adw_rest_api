<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not valid ' . $e], 401);
        }
        // try {
        //     $headers = apache_request_headers(); //get header
        //     $request->headers->set('Authorization', $headers['authorization']); // set header in request

        //     $user = JWTAuth::parseToken()->authenticate();
        // } catch (Exception $e) {
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
        //         return response()->json(['status' => 'Token is Invalid']);
        //     } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        //         return response()->json(['status' => 'Token is Expired']);
        //     } else {
        //         return response()->json(['status' => 'Authorization Token not found']);
        //     }
        // }

        return $next($request);
    }
}

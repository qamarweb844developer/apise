<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // if (!Auth::guard('api')->check()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthorized access. Please provide a valid token middleware.'
        //     ], 401);
        // }

         
               // Get the token from the request header
               $token = $request->bearerToken();

               if (!$token) {
                   return response()->json(['message' => 'Token not provided'], 401);
               }
       
               // Find the token in the database
               $oauthToken = Token::where('id', $token)->first();  
       
               if (!$oauthToken) {
                   return response()->json(['message' => 'Token not found'], 401);
               }
       
               // Check if the token is revoked
               if ($oauthToken->revoked) {
                   return response()->json(['message' => 'Token has been revoked'], 401);
               }
       
               // Check if the token has expired
               if ($oauthToken->expires_at && $oauthToken->expires_at->isPast()) {
                   return response()->json(['message' => 'Token has expired'], 401);
               }

        
        return $next($request);
    }
}

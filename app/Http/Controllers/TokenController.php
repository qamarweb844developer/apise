<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TokenController extends Controller
{
    
    public function regenerate(Request $request)
    {
        // Assuming the current user is authenticated
        $user = Auth::user();
        
        // Revoke all old tokens for the user (this will invalidate all the previous tokens)
        foreach ($user->tokens as $token) {
            $token->delete();
        }
         
        // Generate a new token
        $newToken = $user->createToken('bearer_token')->accessToken;

        // Return the new token with only part of it visible
      

        return response()->json([
            'token' => $newToken,
            'message' => 'Token regenerated successfully.'
        ]);
    }

    public function revoke(Request $request)
    {
        $user = Auth::user();
        
        // Revoke the current token by deleting it
        $token = $user->tokens->first(); // Get the user's first token (you can modify this logic)
        
        if ($token) {
            $token->update(['revoked' => true]); // Revoke the token by setting the 'revoked' flag to true
            return response()->json(['message' => 'Token revoked successfully.']);
        }

        return response()->json(['message' => 'No active token found.'], 404);
    }

    public function enable(Request $request)
    {
        $user = Auth::user();
        
        // Example: You could find the revoked token and re-enable it.
        // You might store a flag in the database to track revoked tokens.
        $token = $user->tokens->where('revoked', true)->first();

        if ($token) {
            $token->update(['revoked' => false]); // Re-enable the token
            return response()->json(['message' => 'Token re-enabled successfully.']);
        }

        return response()->json(['message' => 'No revoked token found.'], 404);
    }


}

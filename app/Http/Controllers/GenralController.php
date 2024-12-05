<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenralController extends Controller
{
    
 














    

public function redditAccesToken(){



//     $client_id = "I30c67JnyUZGWW0rApqzTg";
// $client_secret = "VNCphO96YXObRlAu9G0CGyNlMVorzQ";
// $redirect_uri = "http://localhost/apise/public/reddit_callback_url";
// $code = "Ix6oR3R7vxF3yeMXQomjhsdB_ZHQ4Q"; // Replace with your actual code from Reddit

// // Prepare POST request
// $token_url = "https://www.reddit.com/api/v1/access_token";

// // Basic Auth
// $auth = base64_encode("$client_id:$client_secret");

// // cURL setup
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $token_url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
//     "grant_type" => "authorization_code",
//     "code" => $code,
//     "redirect_uri" => $redirect_uri
// ]));
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     "Authorization: Basic $auth",
//     "Content-Type: application/x-www-form-urlencoded",
//     "User-Agent: MyRedditApp/1.0 by Mukhtar_Ahmed274" // Update this line
// ]);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // Execute the request and decode the response
// $response = curl_exec($ch);
// $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// curl_close($ch);

// if ($http_code == 200) {
//     $token_data = json_decode($response, true);
//     echo "Access Token: " . $token_data['access_token'];
// } else {
//     echo "Error: " . $response;
// }


    $client_id = "I30c67JnyUZGWW0rApqzTg";
    $client_secret = "VNCphO96YXObRlAu9G0CGyNlMVorzQ";
    $redirect_uri = "http://localhost/apise/public/reddit_callback_url";
    $code = "Ix6oR3R7vxF3yeMXQomjhsdB_ZHQ4Q"; // Replace with your actual code from Reddit
    
    // Prepare POST request
    $token_url = "https://www.reddit.com/api/v1/access_token";
    
    // Basic Auth
    $auth = base64_encode("$client_id:$client_secret");
    
    // cURL setup
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => $redirect_uri
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic $auth",
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the request and decode the response
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200) {
        $token_data = json_decode($response, true);
        echo "Access Token: " . $token_data['access_token'];
    } else {
        echo "Error: " . $response;
    }
    

}



}

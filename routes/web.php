<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\GenralController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Stripe Payment Gateway
Route::get('/stripe',[StripeController::class,'index']); 


// Pdfs - Signed
Route::get('/genrate-pdf',[PdfController::class,'index']);

// Route::get('/', function () {
//     $data = [];

//     // $pdf = Pdf::loadView('pdf.template', $data);
//     $pdf = Pdf::loadHTML(' i am pdf from web file');

//     // Return the PDF directly in the browser
//     return $pdf->stream('sample.pdf');

//     // To download the PDF
//     // return $pdf->download('sample.pdf');
   
// });





//   For Google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/redirect-back-google', function () {
    $user = Socialite::driver('google')->user();
 p($user);
});



//   For Linkedin
Route::get('/auth/linkedin', function () {
    return Socialite::driver('linkedin')->scopes(['email'])->redirect();
});
 
Route::get('/redirect-back-linkedin', function () {
    $user = Socialite::driver('linkedin')->user();
 p($user);
});



//   For Reddit
Route::get('/auth/reddit', function () {
    return  redirect('https://www.reddit.com/api/v1/authorize?client_id=I30c67JnyUZGWW0rApqzTg&response_type=code&state=abcdefg&redirect_uri=http://localhost/apise/public/reddit_callback_url&duration=temporary&scope=identity');
});
 
Route::get('/reddit_callback_url', function () {
   // $user = Socialite::driver('linkedin')->user();
//  p($user);
p(request()->all());

});




Route::get('/reddit/at', [GenralController::class, 'redditAccesToken']);







// ?state=fbshh+bgsdfnihjbhghsdfj&code=3ioSOosRkZxWgl-9ePKarc38D9pucQ#_

// https://www.reddit.com/api/v1/authorize?client_id=I30c67JnyUZGWW0rApqzTg&response_type=code&state=fbshh%20bgsdfnihjbhghsdfj&redirect_uri=http://localhost/apise/public/reddit_callback_url&duration=temporary&scope=identity

// https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=7863ddglco7xbk&redirect_uri=http://127.0.0.1:8000/redirect-back-linkedin&scope=email

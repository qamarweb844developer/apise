<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
class StripeController extends Controller
{
    //

    public function index(){
        $amount = rand(10,999);
        \Stripe\Stripe::setApiKey('sk_test_51QOKd1Jqq0GlErgSInANMAT9oSa0FQQTNHG6tplzDRUIhdcism8L7cagAUxZz2H3x8CfSHBI0Xd3r9cz9P1nQ11b00VLVBmMAG');
  
        $intent = \Stripe\PaymentIntent::create([
              'amount' => ($amount)*100,
              'currency' => 'INR',
              'metadata' => ['integration_check'=>'accept_a_payment']
        ]);
  
        $data = array(
             'name'=> 'Sandeep',
             'email'=> 'email@gmail.com',
             'amount'=> $amount,
             'client_secret'=> $intent->client_secret,
        );
       
       return view('stripe',['data'=>$data]);
  
      }
  
      public function success(){
       return view('success');
      }


}

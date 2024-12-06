<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    // Admin = 1 
    // Client = 2
    // Client_Users = 3

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all();
        if (count($users) > 0) {

            $responses = [
                'message' => count($users) . 'Users Found',
                'data' => $users
            ];
        } else {
            $responses = [
                'message' => '0 Users Found'
            ];
        }


        return response()->json([
            $responses
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        //
        $validator  = Validator::make(request()->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

       // Find the user by email
$user = User::where('email', $request['email'])->first();

if ($user && Hash::check($request['password'], $user->password)) {
    // Authentication successful
} else {
    // Authentication failed
    return response()->json(['error' => 'Invalid credentials'], 401);
}
      
        // p(  $user);
        $token = $user->createToken('auth_token')->accessToken;

        if (!is_null($user)) {
            return response()->json([
                'message' => 'user Login Successfully.',
                'user' => $user,
                'token' => $token,
            ], 200);
        }



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator  = Validator::make(request()->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {

            DB::beginTransaction();
            $user = null;
            $token = null;
            try {
                $user = new User();
                $user->name =  request('name');
                $user->email =  request('email');
                $user->password =  Hash::make(request('password'));
                $user->save();

                $token = $user->createToken('auth_token')->accessToken;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }

            if (!is_null($user)) {
                return response()->json([
                    'message' => 'user registred Successfully.',
                    'user' => $user,
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'Message' => 'user registred UnSuccessfully.'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $user  = User::find($id);
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json([
                'Message' => 'user not founds.'
            ], 200);
        } else {
            return response()->json([
                'Message' => 'user  founds.',
                'data' => $user
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update user 
        // p($request['name']);

        $user  = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'Message' => 'user Does not exist'
            ], 200);
        } else {
            DB::beginTransaction();
            try {
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->save();
                DB::commit();
                $respConcde = 200;
                $message = 'User UPdated Successfully.';
            } catch (\Exception $e) {
                //throw $th;
                DB::rollBack();
                $respConcde = 500;
                $message = 'Internal Server Error.';
            }


            return response()->json([
                'Message' => $message,
            ], $respConcde);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user  = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'Message' => 'user Does not exist'
            ], 200);
        } else {
            DB::beginTransaction();
            try {
                $user->delete();
                DB::commit();
                $respConcde = 200;
                $message = 'User deleted Successfully.';
            } catch (\Exception $e) {
                //throw $th;
                DB::rollBack();
                $respConcde = 500;
                $message = 'Internal Server Error.';
            }


            return response()->json([
                'Message' => $message,
            ], $respConcde);
        }
    }
}

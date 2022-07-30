<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login (Request $request) {
        $login_credentials=[
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            //generate the token for the user
            $user = auth()->user();
            $user_login_token= $user->createToken('BS Task Management App')->accessToken;
            //now return this token on success login attempt
            return response()->json(['token' => $user_login_token, 'user' => new UserResource($user)], 200);
        }
        else{
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    public function register(Request $request)
    {
     $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);
    if ($validator->fails())
    {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
    $request['password']=Hash::make($request['password']);
    $request['remember_token'] = Str::random(10);
    $user = User::create($request->toArray());
    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
    $response = ['token' => $token];
    return response($response, 200);
    }
}

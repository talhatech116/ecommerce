<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {

        $user = User::find(Auth::user()->id);
        if($user->role == 'admin'){

            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
            ], 400);

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Access'
            ], 400);
        }


        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Access'
            ], 400);
        }

    }
}

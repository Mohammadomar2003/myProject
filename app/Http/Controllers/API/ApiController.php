<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function register(Request $request)
    {
        {
            $validator=Validator::make($request->all(),
                [
                    'username'=>'required|string',
                    'mobile'=>'required',
                    'password'=>'required|min:4',
                ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' =>'Invalid request data.',
                    'errors' => $validator->errors(),
                ], 400);
            }
            $user=new User;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->mobile = $request->mobile;
            $user->save();

            if (!$token = auth()->attempt($request->all())) {
                return response()->json([
                    "status" => 0,
                    "message" => "Invalid credentials"
                ]);
            }
            $token = auth()->user()->createToken("secret key")->plainTextToken;

            return response()->json([
                'message' =>'account created successfully',
                'plainTextToken'=>$token
            ]);
        }
    }
//---------------------------------------------------------------
// USER LOGIN API - POST
    public function login(Request $request)
    {
        // validation
        $request->validate([

            "mobile" => "required",
            "password" => "required"
        ]);

        // verify user + token
        if (!$token = auth()->attempt($request->all())) {
            return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }
        $token = auth()->user()->createToken("secret key")->plainTextToken;
        // send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "plainTextToken" => $token

        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ], 200);

    }
}

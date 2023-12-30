<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function user_register(Request $request){
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'shop_name' => 'required',
                    'username'=>'required',
                    'mobile' => ['required','max:+963999999999','min:+963910000000','integer'],
                    'password' => 'required',
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'errors' => $validateUser->errors()->first()
                ], 401);
            }
            $user = User::create([
                'shop_name' => $request->shop_name,
                'username' => $request->username,
                'mobile'=>$request->mobile,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'id'=>$user->id,
                'token' => $user->createToken('mobile',['role:user'])->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
                // 'message' => $th->getMessage()
            ], 500);
        }
    }
    public function loginUser(Request $request) {
        $validateUser = Validator::make($request->all(),
            [
                'mobile' => ['required','max:+963999999999','min:+963910000000','integer'],
                'password' => 'required',
            ]);

        if($validateUser->fails()){
            return response()->json([
                'errors' => $validateUser->errors()->first()
            ], 401);
        }
        $user = User::where('mobile', $request->mobile)->first();
        if(!$user->role==0) {
                if(!$user || !Hash::check($request->password,$user->password)){
                return response()->json([
                    'error'=>'Password or phone incorrect'
                ]);
            }
        }
        return response()->json([
            'id'=>$user->id,
            'token'=> $user->createToken('mobile',['role:user'])->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'logout successfully'
        ], 200);

    }

}

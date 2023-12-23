<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Cassandra\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    //
    public function showCategoryMedicinesW(Request $request,$id)
    {
        $medicines = DB::table('medicines')
            ->join('warehouses', 'medicines.warehouse_id', '=', 'warehouses.id')
            ->join('categories', 'medicines.category_id', '=', 'categories.id')
            ->where('warehouses.id', '=', $id)
            ->where('categories.id', '=', $request->category)
            ->select()
            ->get();
        $array=[
            'data'=>$medicines,
            'msg'=>'ok',
            'status'=>200
        ];
        return response($array);
    }

    public function register(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'WareHousename' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $warehouses = Warehouse::class::create([
                'WareHousename' => $request->WareHousename,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'id'=>$warehouses->id,
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $warehouses->createToken("API Token")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([

                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
//---------------------------------------------------------------
// USER LOGIN API - POST
    public function login(Request $request)
    {
        $request->validate([
            'WareHousename' => 'required',
            'password' => 'required',
        ]);

        $user = Warehouse::where('WareHousename', $request->WareHousename)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'WareHousename' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'customer' => $user,
            'token' => $user->createToken('mobile', ['role:warehouse'])->plainTextToken
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

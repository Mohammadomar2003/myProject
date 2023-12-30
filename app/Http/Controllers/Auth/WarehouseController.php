<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
class WarehouseController extends Controller
{
    //
    public function showCategoryMedicines($id)
    {
        $c1=[];
        $c2=[];
        $c3=[];
        $c4=[];
        $c5=[];
        $medicines = Medicine::all()->where('warehouse_id', $id);
        $i=0;
        foreach ($medicines as $medicine)
        {
            if($medicine->category_id==1)
            {
                $c1[$i]=$medicine;
            }
            else if($medicine->category_id==2)
            {
                $c2[$i]=$medicine;
            }
            else if($medicine->category_id==3)
            {
                $c3[$i]=$medicine;
            }
            else if($medicine->category_id==4)
            {
                $c4[$i]=$medicine;
            }
            else if($medicine->category_id==5)
            {
                $c5[$i]=$medicine;
            }
            $i++;
        }


        $array=[
            'data'=>[
                'Pain Killers'=>$c1,
                'Inflammation'=>$c2,
                'Immunomodulatory Medications'=>$c3,
                'Dermatological Medications'=>$c4,
                'Hormonedisorders Medications'=>$c5
            ],
            'msg'=>'ok',
            'status'=>200
        ];
        return response($array);
    }

//    public function showCategoryMedicines($id)
//    {
//        $categories = [
//            1 => 'Pain Killers',
//            2 => 'Inflammation',
//            3 => 'Immunomodulatory Medications',
//            4 => 'Dermatological Medications',
//            5 => 'Hormonedisorders Medications'
//        ];
//
//        $medicines = Medicine::all()->where('warehouse_id', $id);
//
//        $grouped_medicines = [];
//        foreach ($medicines as $medicine) {
//            $category_id = $medicine->category_id;
//            if (!isset($grouped_medicines[$categories[$category_id]])) {
//                $grouped_medicines[$categories[$category_id]] = [];
//            }
//            $grouped_medicines[$categories[$category_id]][] = $medicine;
//        }
//
//        $response = [
//            'data' => $grouped_medicines,
//            'msg' => 'ok',
//            'status' => 200
//        ];
//        return response($response);
//    }

    public function register(Request $request){
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'WareHouse_name' => 'required',
                    'username'=>'required',
                    'password' => 'required',
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'errors' => $validateUser->errors()->first()
                ], 401);
            }
            $warehouse = Warehouse::create([
                'WareHouse_name' => $request->WareHouse_name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'id'=>$warehouse->id,
                'token' => $warehouse->createToken('mobile',['role:warehouse'])->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
                // 'message' => $th->getMessage()
            ], 500);
        }
    }
//---------------------------------------------------------------
// USER LOGIN API - POST
    public function login(Request $request) {
        $validateUser = Validator::make($request->all(),
            [
                'WareHouse_name' => 'required',
                'password' => 'required',
            ]);

        if($validateUser->fails()){
            return response()->json([
                'errors' => $validateUser->errors()->first()
            ], 401);
        }
        $user = Warehouse::where('WareHouse_name', $request->WareHouse_name)->first();
        if(!$user->role==0) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'Password or phone incorrect'
                ]);
            }
        }
        return response()->json([
            'id'=>$user->id,
            'token'=> $user->createToken('mobile',['role:warehouse'])->plainTextToken
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return Response::json([
            'message' => 'You have been logged out successfully. See you soon! 🙋‍♀️'
        ], 200);
    }
    public function getWarehouse()
    {
        $wareHouse=Warehouse::all();
        $array=[
            'data'=>$wareHouse,
            'message'=>'all warehouse',
            'status'=>200
        ];
        return response($array);
    }
}

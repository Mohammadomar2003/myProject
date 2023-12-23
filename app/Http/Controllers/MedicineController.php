<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Support\Facades\Validator;
use App\Models\Medicine;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\select;

class MedicineController extends Controller
{
    public function index()
    {
        $medicine=Medicine::all();

        $array=[
            'data'=>$medicine,
            'status'=>200,
            'msg'=>'all medicines'
        ];
        return response($array);


    }
    public function details($id)
    {
        $medicine = Medicine::with(['category', 'warehouse'])
            ->where('id', $id)
            ->first();

        if($medicine) {
            return response([
                'data' => $medicine,
                'message'=>'found it',
                'status'=>200
            ]);
        }
        return response([
            'data' => null,
            'message' => 'Medicine not found'
        ], 404);
    }
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'scientific_name' => 'required',
            'commercial_name' => 'required',
            'category_id' => 'required',
            'manufacture_company'=>'required',
            'quantity_available'=>'required',
            'expiration_date'=>'required',
            'price'=>'required',
            'warehouse_id'=>'required'
        ],[
            'scientific_name.required' => 'The scientific name field is required.',
            'commercial_name.required' => 'The commercial name field is required.',
            'category_id.required' => 'The category name field is required.',
            'manufacture_company.required' => 'The manufacture company name field is required.',
            'quantity_available.required' => 'The quantity available name field is required.',
            'expiration_date.required' => 'The expiration date name field is required.',
            'price.required' => 'The price name field is required.',
            'warehouse_id.required' => 'The warehouse name field is required.',
            'expiration_date' => 'date_format:Y-m-d'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'msg'=>'All Field required',
                'errors'=>$validator->errors()
            ]);
        }

        $expirationDate = DateTime::createFromFormat('Y-m-d H:i:s', $request->expiration_date);

        $medicine = Medicine::where('scientific_name', $request->scientific_name)
            ->where('commercial_name', $request->commercial_name)
            ->where('category_id', $request->category_id)
            ->where('manufacture_company', $request->manufacture_company)
            ->where('expiration_date', $expirationDate)
            ->where('warehouse_id', $request->warehouse_id)
            ->first();

        if($medicine) {
            // update existing medicine
            $medicine->quantity_available += $request->quantity_available;
            $medicine->save();
            return response()->json([
                'data'=>$medicine,
                'msg' => 'Medicine updated'
            ]);
        } else {
            // create new medicine
            $medicine = new Medicine;
            $medicine->scientific_name = $request->scientific_name;
            $medicine->commercial_name=$request->commercial_name;
            $medicine->category_id=$request->category_id;
            $medicine->manufacture_company=$request->manufacture_company;
            $medicine->quantity_available=$request->quantity_available;
            $medicine->expiration_date = $expirationDate;
            $medicine->price=$request->price;
            $medicine->warehouse_id=$request->warehouse_id;
            $medicine->save();
        }
        return response()->json([
            "data"=>$medicine,
            "msg"=>"medicine added successfully",
        ]);
    }
    public function search_WhatEver(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'msg'=>'Search Field required',
                'errors'=>$validator->errors()
            ]);
        }
        $searchTerm = $request->all();
        $columns = Schema::getColumnListing((new Medicine())->getTable());
        $results = Medicine::where(function ( $query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                if($column=='quantity_available'|$column=='price'|$column=='warehouse_id'|$column=='id')
                {
                    continue;
                }
                $query->orWhere($column,$searchTerm);
            }
        })->get();
        if (!$results->isEmpty()) {
            return response()->json([
                'data' => $results,
                'msg' => 'found it'
            ],200);
        }
        return response()->json([
            'data' => null,
            'msg' => 'No records found.'
        ],404);
    }
}

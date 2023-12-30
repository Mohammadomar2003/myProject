<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FavouriteController extends Controller
{
    //
    public function store(Request $request,$id)
    {
        Schema::disableForeignKeyConstraints();
        $input= $request->all();
        $data = $request->validate(['medicine_id' => 'required|numeric']);
        $productId = $data['medicine_id'];

        if(!Medicine::find($productId))
            return response()->json(['message' => 'product does not exist, how did you even do that?!'], 400);

        $wishlist = Favourite::where('user_id', $id)
            ->where('medicine_id', $productId)
            ->first();

        if($wishlist) {
            return response()->json(['message' => 'added successfully'], 201); // to avoid duplicates
        }
        Favourite::create([
            'user_id' => $id,
            'medicine_id' => $productId
        ]);
        Schema::enableForeignKeyConstraints();

        return response()->json(['message' => 'added successfully'], 201);
    }


    public function showFavourite($id)
    {
        $favourites = Favourite::all()->where('user_id', $id);

        if($favourites) {
            $array = [
                'data' => $favourites,
                'msg' => 'ok',
                'status' => 200
            ];
            return response($array);
        }
        $array = [
            'data' => null,
            'msg' => 'there is no medicine',
            'status' => 400
        ];
        return response($array);
    }
    public function delete1($id) {

        // Get the favourite record
        $favourite = Favourite::find($id);

        // Check if the record exists
        if(!$favourite) {
            return response()->json(['message' => 'Favourite not found']);
        }

        // Delete the record
        $favourite->delete();

        // Return success response
        return response()->json(['message' => 'Favourite deleted']);

    }
}

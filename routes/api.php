<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\WarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function (){
    Route::get('/categoryMedicines/{id}','showCategoryMedicines');//both
    Route::get('/getCategory','getCategory');//pharmacy&&warehouse
});

Route::controller(WarehouseController::class)->group(function (){
    Route::post('/w/register','register');//warehouse
    Route::post('/w/login','login');//warehouse
    Route::get('/w/logout','logout');//warehouse
    Route::get('/warehouses','getWarehouse');//warehouse
    Route::get('/warehousesMedicines/{id}','showCategoryMedicines');//pharmacy
});

Route::controller(MedicineController::class)->group(function ()
{
    Route::post('/storeMedicine/{id}','store');//warehouse
    Route::get('/medicineDetails/{id}','Details');//pharmacy
    Route::get('/allmedicines','index');//pharmacy
    Route::post('/search_WhatEver','search_WhatEver');//pharmacy
    Route::get('/deleteMedicine/{id}','delete');//warehouse
    Route::get('/update/{id}','update');//warehouse
});

Route::controller(OrderController::class)->group(function (){
    Route::post('/order/store/{id}','storeOrders');//pharmacy
    Route::get('/order/{id}','showUserOrder');//pharmacy
    Route::get('/order/Details/{id}','index');//pharmacy&&warehouse
    Route::post('/order/UpdateStatus/{id}','updateOrderStatus');//warehouse
    Route::get('/order/warehouseOrder/{id}','warehouseOrder');//warehouse
    Route::get('/order/delete/{id}','Deleteorder');//warehouse&&pharmacy
});

Route::controller( UserController::class)->group(function ()
{
    Route::post('/register', 'user_register');//pharmacy
    Route::post('/login', 'loginUser');//pharmacy
    Route::get('/logout', 'logout');//pharmacy
});
Route::controller(FavouriteController::class)->group(function ()
{
    Route::post('/favourite/store/{id}','store');//pharmacy
    Route::get('/favourite/user/{id}','showFavourite');//pharmacy
});

Route::get('/favourite/user/delete/{id}',[FavouriteController::class,'deleteFavourite']);//pharmacy

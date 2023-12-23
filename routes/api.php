<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\WarehouseController;
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
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::get('/logout', [ApiController::class, 'logout']);

Route::post('/warehouse/register', [WarehouseController::class, 'register']);
Route::post('/warehouse/login', [WarehouseController::class, 'login']);
Route::get('/warehouse/logout', [WarehouseController::class, 'logout']);

Route::post('/storeMedicine',[MedicineController::class,'store']);
Route::post('/search_WhatEver',[MedicineController::class,'search_WhatEver']);
Route::get('/categoryMedicines/{id}',[CategoryController::class,'showCategoryMedicines']);
Route::get('/warehousesMedicines/{id}',[WarehouseController::class,'showCategoryMedicinesW']);

Route::get('/allmedicines',[MedicineController::class,'index']);
Route::get('/medicineDetails/{id}',[MedicineController::class,'Details']);
Route::middleware(['auth:sanctum','type.warehouse'])->group(function (){

});
Route::middleware(['auth:sanctum','type.user'])->group(function (){

});

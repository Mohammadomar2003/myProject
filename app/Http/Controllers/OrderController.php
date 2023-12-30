<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\Order_medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    //
    public function storeOrders(Request $request, $id)
    {
        $request->validate([
            'warehouse_id' => 'required',
            'medicines' => 'required|array',
            'amount'=>'required|array'
        ]);
        Schema::disableForeignKeyConstraints();
        $request->input('warehouse_id');

        $order=new Order();

        foreach($request->input('medicines') as $index => $medicine){
            // Create order medicine
            $med=Medicine::class::find($medicine);
            $price = $med->price;
            if($index==0){
                $order->warehouse_id=$request->warehouse_id;
                $order->price=$price*$request->input('amount')[$index];
                $order->user_id=$id;
                $order->save();

            }
            $record = new Order_Medicine;
            $record->medicine_id = $medicine;
            $record->amount = $request->input('amount')[$index];
            $record->order_id = $order->id;
            $record->save();
        }
        Schema::enableForeignKeyConstraints();
        return response()->json([
            'msg' => 'Order added successfully',
            'status' => 200
        ]);
    }

    public function showUserOrder($id)
    {
        $orders = Order::with('warehouse')->where('user_id', $id)->get();
        foreach($orders as $order){
            $order->warehouse_name = $order->warehouse->WareHouse_name;
            unset($order->warehouse);
        }
        if(!$orders->isEmpty())
        {
            return response()->json(['data'=>$orders, 'message'=>'there is all orders'],200);
        }
        return response()->json(['data'=>null, 'message'=>'there is no orders'],400);
    }
    public function index($id)
    {
        $order = Order::find($id);
        if(!$order) {
            return response()->json([
                'data' => null,
                'message' => 'Order not found'
            ], 404);
        }

        $medicineNames = $order->medicines->pluck('scientific_name')->toArray();

        return response()->json([
            'order' => $order,
            'message' => 'Order found'
        ], 200);

    }

    public function UpdateStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);

        $order->payment_status = $request->input('payment_status');
        $order->order_status = $request->input('order_status');

        if ($order->payment_status === 'Sent') {
            $orderMedicines = Order_medicine::where('order_id', $order->id)->get();

            foreach ($orderMedicines as $orderMedicine) {
                $medicine = Medicine::find($orderMedicine->medicine_id);

                if ($medicine->quantity_available >= $orderMedicine->amount) {
                    $medicine->quantity_available -= $orderMedicine->amount;
                    $medicine->save();
                } else {
                    // If there is not enough quantity, update the order status and return an error response
                    $order->payment_status = 'In preparation';
                    $order->order_status = 'Unpaid';

                    $response = [
                        'data' => [
                            $order->payment_status,
                            $order->order_status,
                        ],
                        'message' => 'There is not enough quantity',
                        'status' => 400,
                    ];

                    return response()->json($response);
                }
            }
        }

        $order->save();
        if ($order->payment_status === 'Received')
        {
            $order->delete();
        }
        $response = [
            'data' => [
                $order->payment_status,
                $order->order_status,
            ],
            'message' => 'Order status updated successfully',
            'status' => 200,
        ];

        return response()->json($response);
    }
    public function warehouseOrder($id)
    {
        $orders = Order::where('warehouse_id',$id)->get();
        if($orders)
        {
            $array = [
                'data' => $orders,
                'message' => 'warehouse Orders',
                'status' => 200
            ];
            return response($array);
        }
        $array = [
            'data' => null,
            'message' => 'there is no Orders',
            'status' => 400
        ];
        return response($array);
    }
    public function Deleteorder($id)
    {
        $orders = Order::find($id)->delete();
            return response()->json([
                'message'=>'deleted successfully'
            ]);
    }
}

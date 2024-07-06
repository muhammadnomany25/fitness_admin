<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function techOrders(Request $request)
    {
        $technician = $request->user();

        if (!$technician) {
            return response()->json(['error' => 'Technician Not exist'], 404);
        }

        $orders = Order::where('technician_id', $technician->id)
            ->with('orderInvoices')
            ->get();

        return response()->json(['orders' => $orders], 200);
    }

//    public function techOrders(Request $request)
//    {
//        $technician = $request->user();
//
//        if (!$technician) {
//            return response()->json(['error' => 'Technician Not exist'], 404);
//        }
//
//        $orders = Order::where('technician_id', $technician->id)->get();
//
//        return response()->json(['orders' => $orders], 200);
//    }
}

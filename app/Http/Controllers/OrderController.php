<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function techOrders(Request $request)
    {
        $technician = $request->user();

        if (!$technician) {
            return response()->json(['error' => 'Technician Not exist'], 404);
        }

        $validStatuses = ['new', 'inProgress', 'Duplicated', 'Reassigned'];

        $orders = Order::where('technician_id', $technician->id)
            ->whereIn('status', $validStatuses)
            ->with('orderInvoices')
            ->get();

        return response()->json(['data' => $orders], 200);
    }
}

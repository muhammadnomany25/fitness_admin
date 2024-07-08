<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderInvoice;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $client = Technician::where('phoneNumber', $request->phoneNumber)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                $token = $client->createToken('auth_token')->plainTextToken;
                $response = ['token' => $token, 'data' => $client];
                return response($response, Response::HTTP_OK);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            $response = ["message" => 'Technician does not exist'];
            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function completeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.title' => 'required|string|max:255',
            'items.*.quantity' => 'required|string',
            'items.*.cost' => 'required|numeric',
            'orderId' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $orderId = $validatedData['orderId'];
        $notes = $validatedData['notes'] ?? null;
        $items = $validatedData['items'];

        // Check if the order exists
        $order = Order::find($orderId);

        if ($order) {
            // Update notes if provided
            if (!empty($notes)) {
                $order->notes = $notes;
            }
            $order->technician_id = null;
            $order->save();

            foreach ($items as $itemData) {
                // Save each item to the database
                OrderInvoice::create([
                    'item_name' => $itemData['title'],
                    'order_id' => $orderId,
                    'quantity' => $itemData['quantity'],
                    'item_cost' => $itemData['cost'],
                ]);
            }

            return response()->json(['message' => 'Items and orders saved successfully']);
        } else {
            return response()->json(['error' => 'Order ID ' . $orderId . ' not found'], 404);
        }
    }

    public function updateFcmToken(Request $request)
    {
        $validatedData = $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $fcm_token = $validatedData['fcm_token'];

        $technician = $request->user();

        if (!$technician) {
            return response()->json(['error' => 'Technician Not exist'], 404);
        }

        $technician->fcm_token = $fcm_token;
        $technician->save();

        return response()->json(['message' => 'saved successfully']);

    }
}

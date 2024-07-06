<?php

namespace App\Http\Controllers;

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
}

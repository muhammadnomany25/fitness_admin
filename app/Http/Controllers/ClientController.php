<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $client = Client::where('email', $request->email)->first();
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
            $response = ["message" => 'Client does not exist'];
            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function signup(Request $request)
    {
        // Manually validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phoneNumber' => ['required', 'regex:/^(\+201|01|00201)[0-2,5]{1}[0-9]{8}$/'],
            'password' => 'required|string'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            if (!$client->height) {
                $token = $client->createToken('auth_token')->plainTextToken;
                return response()->json(['message' => 'Client already exists, complete profile', 'token' => $token, "data" => $client], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Client already exists'], 409);
            }
        }

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phoneNumber = $request->phoneNumber;
        $client->password = Hash::make($request->password);
        $client->save();

        $client = Client::where('email', $request->email)->first();
        $token = $client->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Client created successfully', 'token' => $token, "data" => $client], Response::HTTP_OK);
    }

    public function signInSocial(Request $request)
    {
        // Manually validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phoneNumber' => ['required', 'regex:/^(\+201|01|00201)[0-2,5]{1}[0-9]{8}$/'],
            'socialToken' => 'required|string',
            'socialType' => 'required|string'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            $token = $client->createToken('auth_token')->plainTextToken;
            if (!$client->height) {
                return response()->json(['message' => 'Client already exists, complete profile', 'token' => $token, "data" => $client], Response::HTTP_OK);
            } else {
                return response()->json(['token' => $token, "data" => $client], Response::HTTP_OK);
            }
        }

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phoneNumber = $request->phoneNumber;
        //TODO: phone number to be optional, password and to add socialToken and socialType to the clients table
//        $client->socialToken = $request->socialToken;
//        $client->socialType = $request->socialType;
        $client->password = Hash::make("password");
        $client->save();

        $client = Client::where('email', $request->email)->first();
        $token = $client->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Client created successfully', 'token' => $token, "data" => $client], Response::HTTP_OK);
    }

    public function completeProfile(Request $request)
    {
        // Manually validate the request data
        $validator = Validator::make($request->all(), [
            'gender' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'age' => 'required|numeric'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = $request->user();

        if (!$client) {
            return response()->json(['error' => 'Client Not exist'], 404);
        }

        $bmi = $request->weight / (($request->height / 100) * ($request->height / 100));

        $client->height = $request->height;
        $client->weight = $request->weight;
        $client->age = $request->age;
        $client->gender = $request->gender;
        $client->bmi = round($bmi, 2);
        $client->bmi_description = "test bmi message, will calculate later";
        $client->save();

        return response()->json(['message' => 'Client update successfully', "data" => $client], Response::HTTP_OK);
    }

    public function updateFCMToken(Request $request)
    {
        // Manually validate the request data
        $validator = Validator::make($request->all(), [
            'fcmToken' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = $request->user();

        if (!$client) {
            return response()->json(['error' => 'Client Not exist'], 404);
        }

        //TODO: add fcm token to clients table
//        $client->fcmToekn = $request->fcmToken;
//        $client->save();

        return response()->json(['message' => 'Fcm token updated successfully'], Response::HTTP_OK);
    }

    public function deleteProfile(Request $request)
    {
        $client = $request->user();

        if (!$client) {
            return response()->json(['error' => 'Client Not exist'], 404);
        }

        $item = Client::find($request->user()->id);
        $item->delete();

        return response()->json(['message' => 'Account deleted successfully'], Response::HTTP_OK);
    }

    public function editProfile(Request $request)
    {
        // Manually validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phoneNumber' => ['required', 'regex:/^(\+201|01|00201)[0-2,5]{1}[0-9]{8}$/'],
            'gender' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'age' => 'required|numeric'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = $request->user();

        if (!$client) {
            return response()->json(['error' => 'Client Not exist'], 404);
        }


        $existClient = Client::where('email', $request->email)->where('id' , '!=', $request->user()->id)->first();

        if ($existClient) {
            return response()->json(['message' => 'Email used by another account'], Response::HTTP_CONFLICT);
        }

        $existClient = Client::where('phoneNumber', $request->phoneNumber)->where('id' , '!=', $request->user()->id)->first();
        if ($existClient) {
            return response()->json(['message' => 'Phone number used by another account'], Response::HTTP_CONFLICT);
        }

        $bmi = $request->weight / (($request->height / 100) * ($request->height / 100));

        $client->name = $request->name;
        $client->email = $request->email;
        $client->phoneNumber = $request->phoneNumber;
        $client->height = $request->height;
        $client->weight = $request->weight;
        $client->age = $request->age;
        $client->gender = $request->gender;
        $client->bmi = round($bmi, 2);
        $client->bmi_description = "test bmi message, will calculate later";
        $client->save();

        return response()->json(['message' => 'Client update successfully', "data" => $client], Response::HTTP_OK);
    }
}

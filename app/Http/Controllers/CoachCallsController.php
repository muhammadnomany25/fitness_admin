<?php

namespace App\Http\Controllers;

use App\Models\CoachCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachCallsController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phoneNumber' => 'required|string',
            'date' => 'required|string',
            'time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $name = $request->name;
        $phoneNumber = $request->phoneNumber;
        $date = $request->date;
        $time = $request->time;

        $call = new CoachCall();
        $call->name = $name;
        $call->phoneNumber = $phoneNumber;
        $call->date = $date;
        $call->time = $time;
        $call->client_id = $request->user()->id;

        $call->save();

        return response()->json(['data' => $call], 201);
    }
}

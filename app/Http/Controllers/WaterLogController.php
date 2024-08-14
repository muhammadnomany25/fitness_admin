<?php

namespace App\Http\Controllers;

use App\Models\WaterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterLogController extends Controller
{
    public function summary(Request $request)
    {
        // Fetch all water logs related to the authenticated user
        $waterLogs = $request->user()->waterLogs()->get();

        return response()->json($waterLogs);
    }

    public function add(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required|string',
        ]);

        // Add user_id to the validated data
        $validatedData['client_id'] = $request->user()->id();

        $recordType = $request->type;

        if ($recordType == env('SMALL_CUP')) {
            $nameEn = '';
            $nameAr = '';
            $amount = '';
        } else if ($recordType == env('MEDIUM_CUP')) {
            $nameEn = '';
            $nameAr = '';
            $amount = '';
        } else if ($recordType == env('LARGE_CUP')) {
            $nameEn = '';
            $nameAr = '';
            $amount = '';
        }

        $waterLog = new WaterLog();
        $waterLog->type = $request->type;
        $waterLog->nameAr = $nameAr;
        $waterLog->nameEn = $nameEn;
        $waterLog->amount = $amount;
        $waterLog->client_id = $request->user()->id();

        // Create a new water log
        $waterLog = WaterLog::create($validatedData);

        return response()->json($waterLog, 201);
    }

    public function delete($request)
    {
        // Find the water log and delete it
        $waterLog = $request->user()->waterLogs()->findOrFail($request->id);
        $waterLog->delete();

        return response()->json(null, 204);
    }
}

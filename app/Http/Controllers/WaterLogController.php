<?php

namespace App\Http\Controllers;

use App\Enums\WaterRecordTypes;
use App\Models\WaterLog;
use Illuminate\Http\Request;

class WaterLogController extends Controller
{
    public function summary(Request $request)
    {
        // Fetch all water logs related to the authenticated user
        $waterLogs = $request->user()
            ->waterLogs()->latest()->take(5)->get();

        $totalAmountDrunk = $waterLogs->sum('amount');
        $totalToDrink = ($request->user()->weight * 55);
        $percent = round(($totalAmountDrunk / $totalToDrink) * 100);

        return response()->json(['data' => ['total'=> (string) $totalToDrink, 'todaysLog'=> (string) $totalAmountDrunk, 'todaysPercent' => (string) $percent, 'recentLogs' => $waterLogs]]);
    }

    public function all(Request $request)
    {
        // Fetch all water logs related to the authenticated user
        $waterLogs = $request->user()
            ->waterLogs()->latest()->get();

        return response()->json(['data' => $waterLogs]);
    }

    public function add(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required|string',
        ]);

        $recordType = $request->type;

        if ($recordType == WaterRecordTypes::SMALL_CUP->value) {
            $nameEn = 'Cup';
            $nameAr = 'كوب';
            $amount = '100';
        } else if ($recordType == WaterRecordTypes::MEDIUM_CUP->value) {
            $nameEn = 'Medium Cup';
            $nameAr = 'كوب متوسط';
            $amount = '180';
        } else if ($recordType == WaterRecordTypes::LARGE_CUP->value) {
            $nameEn = 'Large Cup';
            $nameAr = 'كوب كبير';
            $amount = '250';
        }

        $waterLog = new WaterLog();
        $waterLog->type = $request->type;
        $waterLog->nameAr = $nameAr;
        $waterLog->nameEn = $nameEn;
        $waterLog->amount = $amount;
        $waterLog->client_id = $request->user()->id;

        // Create a new water log
        $waterLog->save();

        return response()->json(['data' => $waterLog], 201);
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|int',
        ]);

        $raw_id = $validatedData["id"];

        // Find the water log and delete it
        $waterLog = $request->user()->waterLogs()->findOrFail($raw_id);
        $waterLog->delete();

        return response()->json(['message' => 'Deleted Successfully']);
    }
}

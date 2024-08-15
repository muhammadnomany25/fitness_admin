<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutFavourite;
use Exception;
use Illuminate\Http\Request;

class WorkoutFavouriteController extends Controller
{
    public function addToFavourite(Request $request)
    {
        try {
            $exercise_id = $request->input('exercise_id');
            $userId = $request->user()->id;

            $favourite = WorkoutFavourite::where('client_id', $userId)->where('exercise_id', $exercise_id)->first();

            if (!$favourite) {
                WorkoutFavourite::create([
                    'client_id' => $userId,
                    'exercise_id' => $exercise_id,
                ]);
                return response()->json(['message' => 'Exercise add to favourites'], 200);
            }
            return response()->json(['message' => 'Exercise already added to favourites'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'not a valid exercise'], 500);
        }
    }

    public function removeFromFavourite(Request $request)
    {
        $exercise_id = $request->input('exercise_id');
        $userId = $request->user()->id;

        $favourite = WorkoutFavourite::where('client_id', $userId)->where('exercise_id', $exercise_id)->first();

        if ($favourite) {
            // Remove from favourites
            $favourite->delete();
            return response()->json(['message' => 'Exercise removed from favourites'], 200);
        }
        return response()->json(['message' => 'Exercise is not a favourites'], 201);
    }

    public function getFavourites(Request $request)
    {
        $userId = $request->user()->id;

        $favourites = Exercise::whereHas('favourites', function ($query) use ($userId) {
            $query->where('client_id', $userId);
        })->get();

        return response()->json(['data' => $favourites], 200);
    }
}

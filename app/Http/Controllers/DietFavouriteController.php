<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\DietFavourite;
use Exception;
use Illuminate\Http\Request;

class DietFavouriteController extends Controller
{
    public function addToFavourite(Request $request)
    {
        $mealId = $request->input('meal_id');
        $userId = $request->user()->id;
        try {
            $favourite = DietFavourite::where('client_id', $userId)->where('meal_id', $mealId)->first();

            if (!$favourite) {
                DietFavourite::create([
                    'client_id' => $userId,
                    'meal_id' => $mealId,
                ]);
                return response()->json(['message' => 'Meal add to favourites'], 200);
            }
            return response()->json(['message' => 'Meal already added to favourites'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'not a valid diet meal'], 500);
        }
    }

    public function removeFromFavourite(Request $request)
    {
        $mealId = $request->input('meal_id');
        $userId = $request->user()->id;

        $favourite = DietFavourite::where('client_id', $userId)->where('meal_id', $mealId)->first();

        if ($favourite) {
            // Remove from favourites
            $favourite->delete();
            return response()->json(['message' => 'Meal removed from favourites'], 200);
        }
        return response()->json(['message' => 'Meal is not a favourites'], 201);
    }

    public function getFavourites(Request $request)
    {
        $userId = $request->user()->id;

        $favourites = Diet::whereHas('favourites', function ($query) use ($userId) {
            $query->where('client_id', $userId);
        })->leftJoin('diet_favourites', function ($join) use ($userId) {
            $join->on('diets.id', '=', 'diet_favourites.meal_id')
                ->where('diet_favourites.client_id', '=', $userId);
        })
            ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
            ->get()
            ->map(function ($meal) {
                $meal->is_fav = !is_null($meal->is_fav);
                return $meal;
            });

        return response()->json(['data' => $favourites], 200);
    }
}

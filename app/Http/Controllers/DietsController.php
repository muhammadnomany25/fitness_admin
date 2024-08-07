<?php

namespace App\Http\Controllers;

use App\Models\CategoryDiet;
use App\Models\Diet;
use App\Models\Order;
use Illuminate\Http\Request;

class DietsController extends Controller
{

    public function dietCats(Request $request)
    {
        $items = CategoryDiet::get();

        return response()->json(['data' => $items], 200);
    }

    public function dietMeals(Request $request)
    {
        $cats = Diet::get();

        return response()->json(['data' => $cats], 200);
    }

    public function snacksDietMeals(Request $request)
    {
        $items = Diet::whereJsonContains('suitable_for', 'snacks')->get();

        return response()->json(['data' => $items], 200);
    }

    public function breakfastDietMeals(Request $request)
    {
        $items = Diet::whereJsonContains('suitable_for', 'breakfast')->get();

        return response()->json(['data' => $items], 200);
    }

    public function launchDietMeals(Request $request)
    {
        $items = Diet::whereJsonContains('suitable_for', 'launch')->get();

        return response()->json(['data' => $items], 200);
    }

    public function dinnerDietMeals(Request $request)
    {
        $items = Diet::whereJsonContains('suitable_for', 'dinner')->get();

        return response()->json(['data' => $items], 200);
    }
}

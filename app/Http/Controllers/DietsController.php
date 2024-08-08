<?php

namespace App\Http\Controllers;

use App\Models\CategoryDiet;
use App\Models\Diet;
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

    public function summary(Request $request)
    {
        $dietCats = CategoryDiet::latest()
            ->take(5)
            ->get();

        $snackDiet = Diet::whereJsonContains('suitable_for', 'snacks')
            ->latest()
            ->take(5)
            ->get();

        $breakfastDiet = Diet::whereJsonContains('suitable_for', 'breakfast')
            ->latest()
            ->take(5)
            ->get();

        $launchDiet = Diet::whereJsonContains('suitable_for', 'launch')
            ->latest()
            ->take(5)
            ->get();

        $dinnerDiet = Diet::whereJsonContains('suitable_for', 'dinner')
            ->latest()
            ->take(5)
            ->get();

        return response()->json(['data' => ['categories' => $dietCats, 'snackMeals' => $snackDiet, 'breakfastMeals' => $breakfastDiet, 'launchMeals' => $launchDiet, 'dinnerMeals' => $dinnerDiet]], 200);
    }
}

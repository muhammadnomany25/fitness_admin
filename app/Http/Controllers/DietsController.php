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
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $meals = Diet::leftJoin('diet_favourites', function ($join) use ($userId) {
                $join->on('diets.id', '=', 'diet_favourites.meal_id')
                    ->where('diet_favourites.client_id', '=', $userId);
            })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $meals = Diet::get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }

        return response()->json(['data' => $meals], 200);
    }

    public function snacksDietMeals(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Diet::whereJsonContains('suitable_for', 'snacks')
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $items = Diet::whereJsonContains('suitable_for', 'snacks')->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function breakfastDietMeals(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Diet::whereJsonContains('suitable_for', 'breakfast')
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $items = Diet::whereJsonContains('suitable_for', 'breakfast')->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function launchDietMeals(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Diet::whereJsonContains('suitable_for', 'launch')
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $items = Diet::whereJsonContains('suitable_for', 'launch')->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function dinnerDietMeals(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Diet::whereJsonContains('suitable_for', 'dinner')
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $items = Diet::whereJsonContains('suitable_for', 'dinner')->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function summary(Request $request)
    {
        $dietCats = CategoryDiet::latest()
            ->take(5)
            ->get();

        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $snackDiet = Diet::whereJsonContains('suitable_for', 'snacks')
                ->latest()
                ->take(5)
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $breakfastDiet = Diet::whereJsonContains('suitable_for', 'breakfast')
                ->latest()
                ->take(5)
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $launchDiet = Diet::whereJsonContains('suitable_for', 'launch')
                ->latest()
                ->take(5)
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $dinnerDiet = Diet::whereJsonContains('suitable_for', 'dinner')
                ->latest()
                ->take(5)
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $snackDiet = Diet::whereJsonContains('suitable_for', 'snacks')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $breakfastDiet = Diet::whereJsonContains('suitable_for', 'breakfast')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $launchDiet = Diet::whereJsonContains('suitable_for', 'launch')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

            $dinnerDiet = Diet::whereJsonContains('suitable_for', 'dinner')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        }


        return response()->json(['data' => ['categories' => $dietCats, 'snackMeals' => $snackDiet, 'breakfastMeals' => $breakfastDiet, 'launchMeals' => $launchDiet, 'dinnerMeals' => $dinnerDiet]], 200);
    }

    public function dietCategoryMeals(Request $request, $id)
    {
        $userId = $request->user()->id;

        if (!empty($userId)) {
            $items = Diet::where('category_diet_id', $id)
                ->leftJoin('diet_favourites', function ($join) use ($userId) {
                    $join->on('diets.id', '=', 'diet_favourites.meal_id')
                        ->where('diet_favourites.client_id', '=', $userId);
                })
                ->select('diets.*', \DB::raw('diet_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    // Add an `is_fav` attribute based on whether the meal is in the favorites table
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });
        } else {
            $items = Diet::where('category_diet_id', $id)->get();
        }

        return response()->json(['data' => $items], 200);
    }
}

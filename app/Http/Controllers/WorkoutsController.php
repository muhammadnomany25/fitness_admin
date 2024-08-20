<?php

namespace App\Http\Controllers;

use App\Models\BodyPart;
use App\Models\Equipment;
use App\Models\Exercise;
use Illuminate\Http\Request;

class WorkoutsController extends Controller
{

    public function summary(Request $request)
    {
        $bodyParts = BodyPart::latest()
            ->take(5)
            ->get();

        $equipments = Equipment::latest()
            ->take(5)
            ->get();

        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $workouts = Exercise::latest()
                ->take(5)
                ->leftJoin('workout_favourites', function ($join) use ($userId) {
                    $join->on('exercises.id', '=', 'workout_favourites.exercise_id')
                        ->where('workout_favourites.client_id', '=', $userId);
                })
                ->select('exercises.*', \DB::raw('workout_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

        } else {
            $workouts = Exercise::latest()
                ->take(5)
                ->get()
                ->map(function ($exercise) {
                    $exercise->is_fav = !is_null($exercise->is_fav);
                    return $exercise;
                });
        }

        return response()->json(['data' => ['bodyParts' => $bodyParts, 'equipments' => $equipments, 'workouts' => $workouts]], 200);
    }

    public function bodyParts(Request $request)
    {
        $items = BodyPart::get();

        return response()->json(['data' => $items], 200);
    }

    public function equipments(Request $request)
    {
        $items = Equipment::get();

        return response()->json(['data' => $items], 200);
    }

    public function exercises(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Exercise::leftJoin('workout_favourites', function ($join) use ($userId) {
                $join->on('exercises.id', '=', 'workout_favourites.exercise_id')
                    ->where('workout_favourites.client_id', '=', $userId);
            })
                ->select('exercises.*', \DB::raw('workout_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

        } else {
            $items = Exercise::get()
                ->map(function ($exercise) {
                    $exercise->is_fav = !is_null($exercise->is_fav);
                    return $exercise;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function bodyPartExercises(Request $request, $id)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Exercise::where('body_part_id', $id)
                ->leftJoin('workout_favourites', function ($join) use ($userId) {
                    $join->on('exercises.id', '=', 'workout_favourites.exercise_id')
                        ->where('workout_favourites.client_id', '=', $userId);
                })
                ->select('exercises.*', \DB::raw('workout_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

        } else {
            $items = Exercise::where('body_part_id', $id)->get()
                ->map(function ($exercise) {
                    $exercise->is_fav = !is_null($exercise->is_fav);
                    return $exercise;
                });
        }

        return response()->json(['data' => $items], 200);
    }

    public function equipmentExercises(Request $request, $id)
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $items = Exercise::where('equipment_id', $id)
                ->leftJoin('workout_favourites', function ($join) use ($userId) {
                    $join->on('exercises.id', '=', 'workout_favourites.exercise_id')
                        ->where('workout_favourites.client_id', '=', $userId);
                })
                ->select('exercises.*', \DB::raw('workout_favourites.id as is_fav'))
                ->get()
                ->map(function ($meal) {
                    $meal->is_fav = !is_null($meal->is_fav);
                    return $meal;
                });

        } else {
            $items = Exercise::where('equipment_id', $id)->get()
                ->map(function ($exercise) {
                    $exercise->is_fav = !is_null($exercise->is_fav);
                    return $exercise;
                });
        }

        return response()->json(['data' => $items], 200);
    }
}

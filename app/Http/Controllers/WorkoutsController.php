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

        $workouts = Exercise::latest()
            ->take(5)
            ->get();

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
        $items = Exercise::get();

        return response()->json(['data' => $items], 200);
    }

    public function bodyPartExercises($id)
    {
        $items = Exercise::where('body_part_id', $id)->get();

        return response()->json(['data' => $items], 200);
    }

    public function equipmentExercises($id)
    {
        $items = Exercise::where('equipment_id', $id)->get();

        return response()->json(['data' => $items], 200);
    }
}

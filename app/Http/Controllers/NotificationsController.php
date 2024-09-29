<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function index(Request $request)
    {
        $items = Notification::get();

        return response()->json(['data' => $items], 200);
    }
}

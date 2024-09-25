<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
            'data' => [
                [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ],
                [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ], [
                    'image' => 'https://static.vecteezy.com/system/resources/previews/009/394/762/original/bell-icon-transparent-notification-free-png.png',
                    'title' => 'test',
                    'content' => 'test notification content'
                ],
            ],
        ];

        // Return JSON response
        return response()->json($data);
    }
}

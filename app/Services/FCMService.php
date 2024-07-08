<?php

namespace App\Services;

use GuzzleHttp\Client;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService
{


    public function __construct()
    {

    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {

        $firebase = (new Factory())
            ->withServiceAccount(env('GOOGLE_APPLICATION_CREDENTIALS'))
            ->withDatabaseUri('https://fast-tec-app-default-rtdb.firebaseio.com');

        $cloudMessaging = $firebase->createMessaging();

        $config = AndroidConfig::fromArray([
            'priority' => 'high',
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => __DIR__ . '/notification_sound.mp3',
                'channel_id' => 'akc_tech_high_channel'
            ],
        ]);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create($title, $body))
            ->withAndroidConfig($config)
            ->withData($data);

        $cloudMessaging->send($message);
    }
}

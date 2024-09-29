<?php

namespace App\Services;

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService
{


    public function __construct()
    {

    }

    public function sendNotification($title, $body, $data = [])
    {

        $firebase = (new Factory())
            ->withServiceAccount(env('GOOGLE_APPLICATION_CREDENTIALS'));

        $cloudMessaging = $firebase->createMessaging();

        $config = AndroidConfig::fromArray([
            'priority' => 'high',
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
        ]);

        $message = CloudMessage::withTarget('topic', 'clients')
            ->withNotification(Notification::create($title, $body))
            ->withAndroidConfig($config)
            ->withData($data);

        try {
            $cloudMessaging->send($message);
        } catch (MessagingException|FirebaseException $e) {
        }
    }
}

<?php

namespace App\Observers;

use App\Models\Notification;
use App\Services\FCMService;
use Illuminate\Support\Facades\App;

class NotificationObserver
{

    public function created(Notification $notification)
    {
        $this->notifyUsers($notification);
    }

    protected function notifyUsers(Notification $notification)
    {
        $title = $notification->title;
        $content = $notification->content;
        $fcmService = App::make(FCMService::class);
        $fcmService->sendNotification($title, $content);
    }
}

<?php

namespace App\Service;

use App\Events\Forum\StoreNotificationEvent;
use App\Models\Notification;

class NotificationService
{
    public static function store($message, $page, $title)
    {
        $notification = Notification::query()->create([
            'title' => $title,
            'user_id' => $message->user_id,
            'url' => route('themes.show', $message->theme_id) . '?page=' . $page . '#' . $message->id
        ]);

        event(new StoreNotificationEvent($notification));
    }
}

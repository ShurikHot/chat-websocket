<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Notification\UpdateNotificationRequest;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function updateCollection(UpdateNotificationRequest $request)
    {
        $data = $request->validated();

        Notification::query()->whereIn('id', $data['ids'])->update([
            'is_read' => true
        ]);
    }
}

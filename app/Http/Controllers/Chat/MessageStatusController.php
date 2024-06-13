<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\MessageStatus\UpdateRequest;
use App\Models\Chat\MessageStatus;

class MessageStatusController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        MessageStatus::query()
            ->where('user_id', $data['user_id'])
            ->where('message_id', $data['message_id'])
            ->update([
                'is_read' => true
            ]);
    }
}

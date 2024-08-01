<?php

namespace App\Http\Controllers\Chat;

use App\Events\Chat\StoreMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Message\StoreRequest;
use App\Http\Resources\Chat\Message\MessageResource;
use App\Jobs\StoreMessageStatusJob;
use App\Models\Chat\Message;

class MessageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $message = Message::query()->create([
            'chat_id' => $data['chat_id'],
            'user_id' => auth()->id(),
            'body' => $data['body']
        ]);

        StoreMessageStatusJob::dispatch($data, $message)->onQueue('store_message');

        broadcast(new StoreMessageEvent($message))->toOthers();

        return MessageResource::make($message)->resolve();
    }
}

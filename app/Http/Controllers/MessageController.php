<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Jobs\StoreMessageStatusJob;
use App\Models\Message;

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

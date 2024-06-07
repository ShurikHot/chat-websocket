<?php

namespace App\Jobs;

use App\Events\StoreMessageStatusEvent;
use App\Models\MessageStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreMessageStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $message;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data['userIdsWithoutMe'] as $userId) {
            MessageStatus::query()->create([
                'chat_id' => $this->data['chat_id'],
                'message_id' => $this->message->id,
                'user_id' => $userId
            ]);

            $count = MessageStatus::query()
                ->where('is_read', false)
                ->where('user_id', $userId)
                ->where('chat_id', $this->data['chat_id'])
                ->count();

            broadcast(new StoreMessageStatusEvent($count, $userId, $this->data['chat_id'], $this->message));
        }
    }
}

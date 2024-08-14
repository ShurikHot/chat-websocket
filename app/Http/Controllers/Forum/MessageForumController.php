<?php

namespace App\Http\Controllers\Forum;

use App\Events\Forum\StoreMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Complaint\StoreComplaintForumRequest;
use App\Http\Requests\Forum\Message\AnswerNotificationRequest;
use App\Http\Requests\Forum\Message\StoreMessageForumRequest;
use App\Http\Requests\Forum\Message\UpdateMessageForumRequest;
use App\Http\Resources\Forum\Message\MessageForumResource;
use App\Models\Forum\Complaint;
use App\Models\Forum\MessageForum;
use App\Service\NotificationService;
use App\Service\PaginationService;

class MessageForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageForumRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $message = MessageForum::query()->create($data);

        event(new StoreMessageEvent($message));

        return MessageForumResource::make($message)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(MessageForum $messageForum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageForum $messageForum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageForumRequest $request, MessageForum $messageForum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MessageForum $messageForum)
    {
        //
    }

    public function like(MessageForum $message)
    {
        $page = PaginationService::page($message->id, $message->theme_id);

        $result = $message->likedUsers()->toggle(auth()->id());

        if ($result['attached']) {
            NotificationService::storeForum($message, $page, 'Your message has been liked!');
        }
    }

    public function complaint(StoreComplaintForumRequest $request, MessageForum $message)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['message_id'] = $message->id;

        $page = PaginationService::page($message->id, $message->theme_id);

        Complaint::query()->create($data);

        NotificationService::storeForum($message, $page, 'Your message was complainted!');

        return MessageForumResource::make($message)->resolve();
    }

    public function answerNotification(AnswerNotificationRequest $request)
    {
        $data = $request->validated();

        $page = PaginationService::page($data['id'], $data['theme_id']);
        $message = (object)$data;

        NotificationService::storeForum($message, $page, 'Your message was answered!');
    }

}

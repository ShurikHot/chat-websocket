<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Message\StoreMessageForumRequest;
use App\Http\Requests\Forum\Message\UpdateMessageForumRequest;
use App\Http\Resources\Chat\Message\MessageResource;
use App\Http\Resources\Forum\Message\MessageForumResource;
use App\Models\Forum\MessageForum;

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
}

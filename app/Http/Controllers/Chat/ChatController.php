<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Chat\StoreRequest;
use App\Http\Resources\Chat\Chat\ChatResource;
use App\Http\Resources\Chat\Message\MessageResource;
use App\Http\Resources\Chat\User\UserResource;
use App\Models\Chat\Chat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::query()->where('id', '!=', auth()->id())->get();
        $users = UserResource::collection($users)->resolve();

        $chats = auth()->user()
            ->chats()
            ->has('messages')
            ->withCount('unreadableMessage')
            ->with('lastMessage')
            ->with('chatWith')
            ->get();
        $chats = ChatResource::collection($chats)->resolve();
        return inertia('Chat/Index', compact('users', 'chats'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $userIds = array_merge($data['users'], [auth()->id()]);
        sort($userIds);

        $userIdsString = implode('-', $userIds);

        try {
            DB::beginTransaction();

            $chat = Chat::query()->firstOrCreate([
                'users' => $userIdsString,
            ], [
                'title' => $data['title'],
            ]);

            if ($data['title'] != null) {
                $chat->update([
                    'title' => $data['title']
                ]);
            }

            $chat->users()->sync($userIds);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return redirect()->route('chats.show', $chat->id);
    }

    public function show(Chat $chat)
    {
        $users = $chat->users()->get();

        $usersWithoutMe = $users->pluck('id')->toArray();
        $userIdsWithoutMe = array_values(array_filter($usersWithoutMe, function ($user) {
            return $user != auth()->id();
        }));

        $page = request('page') ?? 1;

        $messages = $chat->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.CHAT_PAGINATION', 5), '*', 'page', $page);

        $isLastPage = $messages->lastPage() == $page;

        $messages = MessageResource::collection($messages)->resolve();

        if ($page > 1) {
            return response()->json([
                'is_last_page' => $isLastPage,
                'messages' => $messages
            ]);
        }

        $chat->unreadableMessage()->update([
            'is_read' => true
        ]);

        $users = UserResource::collection($users)->resolve();

        $chat = ChatResource::make($chat)->resolve();
        return inertia('Chat/Show', compact('chat', 'users', 'userIdsWithoutMe', 'messages', 'isLastPage'));
    }
}

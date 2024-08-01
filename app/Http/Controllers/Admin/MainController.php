<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum\Branch;
use App\Models\Forum\MessageForum;
use App\Models\Forum\Theme;
use App\Models\User;

class MainController extends Controller
{
    public function index()
    {
        $statistics = [
            'branches' => Branch::query()->count(),
            'themes' => Theme::query()->count(),
            'messages' => MessageForum::query()->count(),
            'users' => User::query()->count(),
        ];

        return inertia('Admin/Main/Index', compact('statistics'));
    }
}

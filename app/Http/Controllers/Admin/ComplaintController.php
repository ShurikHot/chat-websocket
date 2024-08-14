<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forum\Complaint\ComplaintResource;
use App\Models\Forum\Complaint;
use App\Service\NotificationService;
use App\Service\PaginationService;

class ComplaintController extends Controller
{
    public function index(){
        $complaints = Complaint::all();
        $complaints = ComplaintResource::collection($complaints->load('user'))->resolve();

        return inertia('Admin/Complaint/Index', compact('complaints'));
    }

    public function update(Complaint $complaint){
        $complaint->update([
            'is_solved' => !$complaint->is_solved
        ]);

        $message = (object)[
            'id' => $complaint->message_id,
            'user_id' => $complaint->user_id,
            'theme_id' => $complaint->theme_id
        ];
        $page = PaginationService::page($complaint->message_id, $complaint->theme_id);

        $title = $complaint->is_solved
            ? 'The complaint about your message has been solved'
            : 'The complaint about your message in work';

        NotificationService::storeForum($message, $page, $title);

        return ComplaintResource::make($complaint)->resolve();
    }
}

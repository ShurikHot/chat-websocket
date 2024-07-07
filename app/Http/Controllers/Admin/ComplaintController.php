<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forum\Complaint\ComplaintResource;
use App\Models\Forum\Complaint;
use App\Models\Forum\MessageForum;
use App\Models\Forum\Theme;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(){
        $complaints = Complaint::all();
        $complaints = ComplaintResource::collection($complaints)->resolve();

        return inertia('Admin/Complaint/Index', compact('complaints'));
    }

    public function update(Complaint $complaint){
        $complaint->update([
            'is_solved' => !$complaint->is_solved
        ]);

        return ComplaintResource::make($complaint)->resolve();
    }
}

<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getPageAttribute(){
        $messageId = $this->message_id;
        $theme = Theme::query()->find($this->theme_id);
        $messages = $theme->messages()->orderBy('created_at', 'asc')->pluck('id');
        $index = $messages->search(function ($item) use ($messageId) {
            return $item == $messageId;
        });
        return ceil(($index + 1) / config('constants.FORUM_PAGINATION', 10));
    }
}

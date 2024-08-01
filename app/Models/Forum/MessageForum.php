<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageForum extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'message_user_likes', 'message_id', 'user_id');
    }

    public function getIsLikedAttribute()
    {
        return $this->likedUsers()->where('user_id', auth()->id())->exists();
    }

    public function isNotSolvedComplaint()
    {
        return $this->hasMany(Complaint::class, 'message_id', 'id')
                ->where('user_id', auth()->id())
                ->where('is_solved', false);
    }
}

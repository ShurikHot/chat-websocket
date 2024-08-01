<?php

namespace App\Models\Forum;

use App\Models\User;
use App\Service\PaginationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function message()
    {
        return $this->belongsTo(Theme::class, 'message_id', 'id');
    }

    public function getPageAttribute(){
        return PaginationService::page($this->message_id, $this->theme_id);
    }
}

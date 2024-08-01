<?php

namespace App\Service;

use App\Models\Forum\Theme;

class PaginationService
{
    public static function page($message_id, $theme_id)
    {
        $theme = Theme::query()->find($theme_id);
        $messages = $theme->messages()->orderBy('created_at', 'asc')->pluck('id');
        $index = $messages->search(function ($item) use ($message_id) {
            return $item == $message_id;
        });
        return ceil(($index + 1) / config('constants.FORUM_PAGINATION', 10));
    }
}

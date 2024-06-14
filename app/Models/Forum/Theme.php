<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;
}

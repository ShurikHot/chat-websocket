<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function branches()
    {
        return $this->hasMany(Branch::class, 'section_id', 'id');
    }
    public function parentBranches()
    {
        return $this->hasMany(Branch::class, 'section_id', 'id')->where('parent_id', null);
    }
}

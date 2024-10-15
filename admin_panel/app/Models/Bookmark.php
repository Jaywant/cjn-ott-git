<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'tbl_bookmark';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'is_parent' => 'integer',
        'user_id' => 'integer',
        'video_type' => 'integer',
        'sub_video_type' => 'integer',
        'video_id' => 'integer',
        'status' => 'integer',
    ];
}

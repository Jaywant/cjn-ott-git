<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home_Section extends Model
{
    use HasFactory;

    protected $table = 'tbl_home_section';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'is_home_screen' => 'integer',
        'type_id' => 'integer',
        'video_type' => 'integer',
        'sub_video_type' => 'integer',
        'title' => 'string',
        'short_title' => 'string',
        'category_id' => 'integer',
        'language_id' => 'integer',
        'channel_id' => 'integer',
        'order_by_upload' => 'integer',
        'order_by_like' => 'integer',
        'order_by_view' => 'integer',
        'screen_layout' => 'string',
        'premium_video' => 'integer',
        'rent_video' => 'integer',
        'no_of_content' => 'integer',
        'view_all' => 'integer',
        'sortable' => 'integer',
        'status' => 'integer',
    ];
}

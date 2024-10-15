<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    use HasFactory;

    protected $table = 'tbl_tv_show';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'video_type' => 'integer',
        'channel_id' => 'integer',
        'producer_id' => 'integer',
        'category_id' => 'string',
        'language_id' => 'string',
        'cast_id' => 'string',
        'name' => 'string',
        'thumbnail' => 'string',
        'landscape' => 'string',
        'trailer_type' => 'string',
        'trailer_url' => 'string',
        'description' => 'string',
        'release_date' => 'string',
        'is_title' => 'integer',
        'is_like' => 'integer',
        'is_comment' => 'integer',
        'total_like' => 'integer',
        'total_view' => 'integer',
        'is_rent' => 'integer',
        'price' => 'integer',
        'rent_day' => 'integer',
        'status' => 'integer',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}

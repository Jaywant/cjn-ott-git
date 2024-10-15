<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'tbl_comment';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'comment_id' => 'integer',
        'user_id' => 'integer',
        'video_type' => 'integer',
        'sub_video_type' => 'integer',
        'video_id' => 'integer',
        'episode_id' => 'integer',
        'comment' => 'string',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function getVideoName($video_id, $video_type, $sub_video_type)
    {
        if ($video_type == 1) {
            return Video::where('id', $video_id)->pluck('name')->first();
        } else if ($video_type == 2) {
            return TVShow::where('id', $video_id)->pluck('name')->first();
        } else if ($video_type == 6) {

            if ($sub_video_type == 1) {
                return Video::where('id', $video_id)->pluck('name')->first();
            } else if ($sub_video_type == 2) {
                return TVShow::where('id', $video_id)->pluck('name')->first();
            }
        }
        return "-";
    }
}

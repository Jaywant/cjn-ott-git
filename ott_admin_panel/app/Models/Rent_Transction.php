<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent_Transction extends Model
{
    use HasFactory;

    protected $table = 'tbl_rent_transction';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'unique_id' => 'string',
        'user_id' => 'integer',
        'video_type' => 'integer',
        'video_id' => 'integer',
        'price' => 'integer',
        'transaction_id' => 'string',
        'description' => 'string',
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

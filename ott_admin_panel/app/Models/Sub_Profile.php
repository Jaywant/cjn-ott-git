<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Profile extends Model
{
    use HasFactory;

    protected $table = 'tbl_sub_profile';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'image' => 'string',
        'parent_user_id' => 'integer',
        'status' => 'integer',
    ];
}

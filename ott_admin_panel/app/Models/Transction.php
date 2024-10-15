<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transction extends Model
{
    use HasFactory;

    protected $table = 'tbl_transaction';
    protected $guarded = array();

    protected $casts = [
        'id' => 'integer',
        'unique_id' => 'string',
        'user_id' => 'integer',
        'package_id' => 'integer',
        'transaction_id' => 'string',
        'price' => 'string',
        'description' => 'string',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}

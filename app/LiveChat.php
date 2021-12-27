<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveChat extends Model
{
    protected $fillable = [
        'message', 'customer_id'
    ];
}

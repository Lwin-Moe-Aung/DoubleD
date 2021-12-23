<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tip extends Model
{
    // use HasFactory;
    protected $fillable = [
        'tip', 'is_morning'
    ];

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}

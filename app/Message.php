<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded = [];//黑名单
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

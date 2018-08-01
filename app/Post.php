<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['user_id', 'body'];

    protected $appends = ['createdDate'];
    /**
     * 一条laratwitter只能属于一个user
     */
    public function user(){ 
        return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

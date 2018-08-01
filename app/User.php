<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 用户有很多laratwitter
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    protected $appends = ['profileLink'];

    public function getProfileLinkAttribute()
    {
        return route('user.show', $this);
    }

    /**
     * 一个人有多个粉丝 关联一对多
     */
    public function following(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // 不能关注自己
    public function isNot($user)
    {
        return $this->id !== $user->id;
    }

    // 是否已经关注某用户
    public function isFollowing($user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    // 是否能够关注某用户
    public function canFollow($user)
    {
        if(!$this->isNot($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }

    public function canUnFollow($user)
    {
        return $this->isFollowing($user);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}

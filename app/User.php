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
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
     public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
{
    // confirm if already following
    $exist = $this->is_following($userId);
    // confirming that it is not you
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {
        // do nothing if already following
        return false;
    } else {
        // follow if not following
        $this->followings()->attach($userId);
        return true;
    }
}

public function unfollow($userId)
{
    // confirming if already following
    $exist = $this->is_following($userId);
    // confirming that it is not you
    $its_me = $this->id == $userId;


    if ($exist && !$its_me) {
        // stop following if following
        $this->followings()->detach($userId);
        return true;
    } else {
        // do nothing if not following
        return false;
    }
}


    public function is_following($userId) {
    return $this->followings()->where('follow_id', $userId)->exists();
}

    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    public function favourite()
    {
        return $this->belongsToMany(Micropost::class, 'user_favourite', 'user_id', 'favourite_id')->withTimestamps();
    }
    
    public function favouriting($favouriteId)
{
    // confirm if already following
    $exist = $this->is_favouriting($favouriteId);
    // confirming that it is not you
    $its_me = $this->id == $favouriteId;
    
        if ($exist) {
        // do nothing if already following
        return false;
    } else {
        // follow if not following
        $this->favourite()->attach($favouriteId);
        return true;
    }

}

    public function unfavourite($favouriteId)
{
    // confirming if already following
    $exist = $this->is_favouriting($favouriteId);
    // confirming that it is not you
    $its_me = $this->id == $favouriteId;
    
     if ($exist) {
        // stop following if following
        $this->favourite()->detach($favouriteId);
        return true;
    } else {
        // do nothing if not following
        return false;
    }
}


    public function is_favouriting($favouriteId) {
    return $this->favourite()->where('favourite_id', $favouriteId)->exists();
}

    public function list_favourites()
    {
        $favourite_ids = $this->favouriting()-> pluck('micropost.favourite_id')->toArray();
        $favourite_ids[] = $this->id;
        return Micropost::whereIn('favourite_id', $favourite_ids);
    }
}
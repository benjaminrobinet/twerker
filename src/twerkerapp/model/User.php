<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function tweets(){
        return $this->hasMany(Tweet::class, 'author');
    }

    public function follows(){
        return $this->belongsToMany(User::class, 'follow', 'follower', 'followee');
    }

    public function followedBy(){
        return $this->belongsToMany(User::class, 'follow', 'followee', 'follower');
    }

    public function likes(){
        return $this->belongsToMany(Tweet::class, 'like');
    }
}
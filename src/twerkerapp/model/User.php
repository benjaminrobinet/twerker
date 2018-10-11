<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fullname;
    protected $username;
    protected $password;
    protected $level;
    protected $followers;

    public function tweets(){
        return $this->hasMany(Tweet::class, 'author');
    }
}
<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fullname;
    public $username;
    public $password;
    public $level;
    public $followers;

    public function tweets(){
        return $this->hasMany('twerkerapp\model\Tweet');
    }
}
<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $follower;
    protected $followee;
}
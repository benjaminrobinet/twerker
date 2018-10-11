<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table = 'tweet';
    protected $primaryKey = 'id';

    protected $text;
    protected $author;
    protected $score;

    public function user(){
        return $this->belongsTo(User::class, 'author');
    }
}
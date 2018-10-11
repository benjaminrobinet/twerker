<?php

namespace twerkerapp\model;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table = 'tweet';
    protected $primaryKey = 'id';

    public $text;
    public $author;
    public $score;

    public function user(){
        return $this->belongsTo('twerkerapp\model\User', 'author');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    protected $fillable = ['user_id', 'post_id', 'comment_id', 'type', 'thread_id'];

    const UP_VOTE = 1;
    const DOWN_VOTE = 2;
    const REMOVE_VOTE = 0;
}

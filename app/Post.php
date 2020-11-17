<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['user_created', 'title', 'content', 'up_vote', 'down_vote'];
}

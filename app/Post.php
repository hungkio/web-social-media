<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['user_id', 'title', 'content', 'thread_id', 'up_vote'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')->latest();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id', 'id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }
}

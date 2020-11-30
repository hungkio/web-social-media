<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';
    protected $fillable = ['name', 'parent', 'category_id', 'description', 'user_id'];

    const PARENT = 0;

    public function posts()
    {
        return $this->hasMany(Post::class, 'thread_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'thread_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(ThreadMember::class, 'thread_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['post_id', 'user_id', 'content', 'parent', 'user_reply'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userReply()
    {
        return $this->belongsTo(User::class, 'user_reply', 'id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'comment_id', 'id');
    }
}

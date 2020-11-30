<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadMember extends Model
{
    protected $table = 'thread_members';
    protected $fillable = ['thread_id', 'user_id', 'role', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

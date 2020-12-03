<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';
    protected $fillable = ['thread_id', 'user_id', 'count'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }
}

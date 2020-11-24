<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadMember extends Model
{
    protected $table = 'thread_members';
    protected $fillable = ['thread_id', 'user_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadMember extends Model
{
    protected $table = 'thread_members';
    protected $fillable = ['thread_id', 'user_id', 'role', 'status'];

    const ADMIN = 1;
    const MEMBER = 2;
    const ROLE = [
        self::ADMIN => 'Admin',
        self::MEMBER => 'Member'
    ];
    const APPROVED = 1;
    const DISAPPROVED = 2;
    const STATUS = [
        self::APPROVED => ' Approved',
        self::DISAPPROVED => ' Disapproved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id');
    }

}

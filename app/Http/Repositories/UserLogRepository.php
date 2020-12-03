<?php

namespace App\Http\Repositories;

use App\UserLog;

class UserLogRepository
{
    public function updateOrCreate($thread_id)
    {
        $count = $this->find($thread_id)->count ?? 0;
        return UserLog::updateOrCreate(
            [
                'thread_id' => $thread_id,
                'user_id' => auth()->id(),
            ],
            [
                'count' => ++$count,
            ]
        );
    }

    public function find($thread_id)
    {
        return UserLog::where('user_id', auth()->id())->where('thread_id', $thread_id)->first();
    }

}

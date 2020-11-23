<?php

namespace App\Http\Repositories;

use App\Thread;
use App\Vote;

class ThreadRepository
{
    public function getThreadTop($category_id = null)
    {
        if ($category_id) {
            return Thread::where('category_id', $category_id)->get()->sortByDesc(function ($q) {
                return $q->votes->where('type', Vote::UP_VOTE)->count();
            });
        }
        return Thread::all()->sortByDesc(function ($q) {
            return $q->votes->where('type', Vote::UP_VOTE)->count();
        });
    }

    public function find($id)
    {
        return Thread::findOrFail($id);
    }

}



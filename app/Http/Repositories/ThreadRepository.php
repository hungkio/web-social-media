<?php

namespace App\Http\Repositories;

use App\Thread;
use App\Vote;
use App\ThreadMember;

class ThreadRepository
{
    public function getThreadTop($category_id = null, $user_own = null, $limit = null)
    {
        if ($category_id) {
            if ($user_own) {
                if ($category_id == 1) {
                    return Thread::where('user_id', $user_own)->get()->sortByDesc(function ($q) {
                        return $q->votes->where('type', Vote::UP_VOTE)->count();
                    });
                }
                return Thread::where('category_id', $category_id)->where('user_id', $user_own)->get()->sortByDesc(function ($q) {
                    return $q->votes->where('type', Vote::UP_VOTE)->count();
                });
            }
            if ($category_id == 1) {
                return Thread::all()->sortByDesc(function ($q) {
                    return $q->votes->where('type', Vote::UP_VOTE)->count();
                });
            }
            return Thread::where('category_id', $category_id)->get()->sortByDesc(function ($q) {
                return $q->votes->where('type', Vote::UP_VOTE)->count();
            });
        }
        if ($user_own) {
            return Thread::where('user_id', $user_own)->get()->sortByDesc(function ($q) {
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

    public function join($request)
    {
        if ($request->thread_id) {
            $data = [
                'thread_id' => $request->thread_id,
                'user_id' => auth()->id()
            ];
            if ($request->is_join) {
                return ThreadMember::create($data);
            }
            return ThreadMember::where($data)->delete();
        }
        return false;
    }

    public function search($key, $user_own = null)
    {
        if ($key != '') {
            if ($user_own) {
                return Thread::where('user_id', $user_own)->where('name', 'like', '%' . $key . '%')->get()->sortByDesc(function ($q) {
                    return $q->votes->where('type', Vote::UP_VOTE)->count();
                });
            }
            return Thread::where('name', 'like', '%' . $key . '%')->get()->sortByDesc(function ($q) {
                return $q->votes->where('type', Vote::UP_VOTE)->count();
            });
        }
        return false;
    }

    public function create($data)
    {
        return Thread::create($data);
    }

    public function delete($id)
    {
        return Thread::findOrFail($id)->delete();
    }
}



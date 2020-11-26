<?php

namespace App\Http\Repositories;

use App\Post;
use App\ThreadMember;
use Carbon\Carbon;

class PostRepository
{
    public function create($data)
    {
        return Post::create($data);
    }

    public function getAll($paginate = null)
    {
        $threads = ThreadMember::where('user_id', auth()->id())->get();
        $thread_ids = [];
        if ($threads) {
            foreach ($threads as $thread)
            {
                $thread_ids[] = $thread->thread_id;
            }
        }
        if ($paginate) {
            $data = Post::orWhere('user_id', auth()->id())->orWhereIn('thread_id', $thread_ids)->latest()->paginate($paginate);
        } else {
            $data = Post::orWhere('user_id', auth()->id())->orWhereIn('thread_id', $thread_ids)->latest()->get();
        }
        return $this->diffTime($data);
    }

    public function getPopular($paginate = null)
    {
        if ($paginate) {
            $data = Post::orderBy('up_vote', 'desc')->paginate($paginate);
        } else {
            $data = Post::orderBy('up_vote', 'desc')->get();
        }
        return $this->diffTime($data);
    }

    public function update($id, $data)
    {
        return Post::findOrFail($id)->update($data);
    }

    public function getMyPost($paginate = null)
    {
        if ($paginate) {
            $data = Post::where('user_id', auth()->id())->latest()->paginate($paginate);
        } else {
            $data = Post::where('user_id', auth()->id())->latest()->get();
        }
        return $this->diffTime($data);
    }

    public function delete($id)
    {
        return Post::findOrFail($id)->delete();
    }

    public function find($id)
    {
        return Post::FindOrFail($id);
    }

    public function diffTime($data)
    {
        foreach ($data as $post) {
            $now = Carbon::now();
            $created_at = Carbon::parse($post->created_at);

            if ($now->diff($created_at)->format('%Y') > 0) {
                $post->diff_time = ($now->diff($created_at)->format('%Y') > 1) ?
                    intval($now->diff($created_at)->format('%Y')) . ' years ago' :
                    intval($now->diff($created_at)->format('%Y')) . ' year ago';
            } elseif ($now->diff($created_at)->format('%m') > 0) {
                $post->diff_time = ($now->diff($created_at)->format('%m') > 1) ?
                    intval($now->diff($created_at)->format('%m')) . ' months ago' :
                    intval($now->diff($created_at)->format('%m')) . ' month ago';
            } elseif ($now->diff($created_at)->format('%d') > 0) {
                $post->diff_time = ($now->diff($created_at)->format('%d') > 1) ?
                    intval($now->diff($created_at)->format('%d')) . ' days ago' :
                    intval($now->diff($created_at)->format('%d')) . ' day ago';
            } elseif ($now->diff($created_at)->format('%H') > 0) {
                $post->diff_time = ($now->diff($created_at)->format('%H') > 1) ?
                    intval($now->diff($created_at)->format('%H')) . ' hours ago' :
                    intval($now->diff($created_at)->format('%H')) . ' hour ago';
            } elseif ($now->diff($created_at)->format('%i') > 0) {
                $post->diff_time = ($now->diff($created_at)->format('%i') > 1) ?
                    intval($now->diff($created_at)->format('%i')) . ' minutes ago' :
                    intval($now->diff($created_at)->format('%i')) . ' minute ago';
            } elseif ($now->diff($created_at)->format('%s') != 0) {
                $post->diff_time = 'just now';
            }
        }
        return $data;
    }
}

<?php

namespace App\Http\Repositories;

use App\Post;

class PostRepository
{
    public function create($data)
    {
        return Post::create($data);
    }

    public function getMyPost()
    {
        return Post::where('user_id', auth()->id())->get();
    }
}

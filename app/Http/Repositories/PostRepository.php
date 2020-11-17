<?php

namespace App\Http\Repositories;

use App\Post;

class PostRepository
{
    public function create($data)
    {
        Post::create($data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $data = $request->only('title', 'content');
        $data = array_merge($data, [
            'user_id' => auth()->id(),
            'thead_id' => $request->thread_id ?? 0
        ]);
        try {
            $this->postRepository->create($data);
            //redirect to detail post (comment)
            return back()->with('success', 'Post created success');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }
}

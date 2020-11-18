<?php

namespace App\Http\Controllers;

use App\Http\Repositories\VoteRepository;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;
    protected $voteRepository;

    public function __construct(
        PostRepository $postRepository,
        VoteRepository $voteRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->voteRepository = $voteRepository;
    }

    public function index()
    {
        $data = $this->postRepository->getAll();
        return view('home', [
            'data' => $data ?? ''
        ]);
    }

    public function MyPost()
    {
        $data = $this->postRepository->getMyPost();
        return view('home', [
            'data' => $data ?? ''
        ]);
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
            return redirect()->route('post.my_post');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $data = $this->postRepository->find($id);
        return view('posts.edit', ['data' => $data]);
    }

    public function update(CreatePostRequest $request)
    {
        $data = $request->only('title', 'content');
        $data = array_merge($data, [
            'thead_id' => $request->thread_id ?? 0
        ]);
        try {
            $this->postRepository->update($request->id, $data);
            return redirect()->route('post.my_post');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->postRepository->delete($id);
            return back();
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}

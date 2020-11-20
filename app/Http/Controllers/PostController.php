<?php

namespace App\Http\Controllers;

use App\Http\Repositories\VoteRepository;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\CommentRepository;

class PostController extends Controller
{
    protected $postRepository;
    protected $voteRepository;
    protected $commentRepository;

    public function __construct(
        PostRepository $postRepository,
        VoteRepository $voteRepository,
        CommentRepository $commentRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->voteRepository = $voteRepository;
        $this->commentRepository = $commentRepository;
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
            return redirect()->route('post.my_post');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function comment($id)
    {
        $data = $this->postRepository->find($id);
        if ($data->comments) {
            $comments = $this->commentRepository->formatComment($data->comments);
        }
        return view('posts.comment', [
            'post' => $data,
            'comments' => @$comments,
        ]);
    }

    public function saveComment(Request $request)
    {
        try {
            $data = $request->only('content', 'post_id', 'parent', 'user_reply');
            if ($data['content'] != '') {
                $this->commentRepository->store(array_merge(['user_id' => auth()->id()], $data));
                return response()->json(['success' => 'Comment has been saved']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function deleteComment($id)
    {
        try {
            $this->commentRepository->delete($id);
            return back()->with('success', 'Comment has been deleted');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}

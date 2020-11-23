<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ThreadRepository;
use App\Http\Repositories\VoteRepository;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\UserRepository;

class PostController extends Controller
{
    protected $postRepository;
    protected $voteRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $threadRepository;

    public function __construct(
        PostRepository $postRepository,
        VoteRepository $voteRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        ThreadRepository $threadRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->voteRepository = $voteRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->threadRepository = $threadRepository;
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
        $threads = $this->userRepository->find(auth()->id());
        return view('posts.create', [
            'threads' => $threads->threads ?? ''
        ]);
    }

    public function store(CreatePostRequest $request)
    {
        $data = $request->only('title', 'content');
        $data = array_merge($data, [
            'user_id' => auth()->id(),
            'thread_id' => $request->thread_id ?? 0
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
        $threads = $this->userRepository->find(auth()->id());
        return view('posts.edit', [
            'data' => $data,
            'threads' => $threads->threads ?? '',
        ]);
    }

    public function update(CreatePostRequest $request)
    {
        $data = $request->only('title', 'content');
        $data = array_merge($data, [
            'thread_id' => $request->thread_id ?? 0
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
            $this->postRepository->find($id)->comments()->delete();
            $this->postRepository->find($id)->votes()->delete();
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
            $comments = $this->postRepository->diffTime($data->comments);
            $comments = $this->commentRepository->formatComment($comments);
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
            $this->commentRepository->find($id)->votes()->delete();
            $this->commentRepository->delete($id);
            return back()->with('success', 'Comment has been deleted');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function userPost($id)
    {
        $data = $this->userRepository->find($id);
        return view('home', [
            'data' => $data->post ?? ''
        ]);
    }
}

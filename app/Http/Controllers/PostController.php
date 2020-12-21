<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Repositories\ThreadRepository;
use App\Http\Repositories\VoteRepository;
use App\UserLog;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\UserLogRepository;

class PostController extends Controller
{
    protected $postRepository;
    protected $voteRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $threadRepository;
    protected $userLogRepository;

    public function __construct(
        PostRepository $postRepository,
        VoteRepository $voteRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        ThreadRepository $threadRepository,
        UserLogRepository $userLogRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->voteRepository = $voteRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->threadRepository = $threadRepository;
        $this->userLogRepository = $userLogRepository;
    }

    public function index()
    {
        $data = $this->postRepository->getAll(5);
        $suggest_threads = $this->suggestThreads();
        return view('home', [
            'data' => $data ?? '',
            'suggest_threads' => $suggest_threads ?? '',
        ]);
    }

    public function getPost()
    {
        $data = $this->postRepository->getAll(5);
        $html = '';
        foreach ($data as $post) {
            $html .= view('post-component', compact('post'))->render();
        }
        return response()->json(['data' => $html]);
    }

    public function MyPost()
    {
        $data = $this->postRepository->getMyPost(5);
        $user = auth()->user();
        return view('users.home', [
            'data' => $data ?? '',
            'user' => $user ?? ''
        ]);
    }

    public function getMyPost()
    {
        $data = $this->postRepository->getMyPost(5);
        $html = '';
        foreach ($data as $post) {
            $html .= view('post-component', compact('post'))->render();
        }
        return response()->json(['data' => $html]);
    }

    public function popular()
    {
        $data = $this->postRepository->getPopular(5);
        $suggest_threads = $this->suggestThreads();
        return view('posts.popular', [
            'data' => $data ?? '',
            'suggest_threads' => $suggest_threads ?? '',
        ]);
    }

    public function getPopular()
    {
        $data = $this->postRepository->getPopular(5);
        $html = '';
        foreach ($data as $post) {
            $html .= view('post-component', compact('post'))->render();
        }
        return response()->json(['data' => $html]);
    }

    public function suggestThreads()
    {
        $threads = '';
        if (auth()->id()) {
            // suggest with user logs
            $user_logs = UserLog::where('user_id', auth()->id())->orderBy('count', 'desc')->get();
            if ($user_logs) {
                // lay them thread cung category
                $threads_arr = [];
                foreach ($user_logs as $log) {
                    if ($log->thread->user_id != auth()->id()) {
                        //check member
                        $is_member = 0;
                        foreach ($log->thread->members as $member)
                        {
                            if ($member->user_id == auth()->id()) {
                                $is_member = 1;
                            }
                        }
                        if (!$is_member) {
                            $threads_arr[] = $log->thread;
                        }
                    }
                }

                // first cate
                $category_id = $user_logs[0]->thread->category_id ?? 1;
                $threads_refer = $this->threadRepository->getThreadRecommend($category_id);
                if ($threads_refer) {
                    foreach ($threads_refer as $thread) {
                        if ($thread->user_id != auth()->id()) {
                            //check member
                            $is_member = 0;
                            foreach ($thread->members as $member)
                            {
                                if ($member->user_id == auth()->id()) {
                                    $is_member = 1;
                                }
                            }
                            if (!$is_member) {
                                $threads_arr[] = $thread;
                            }
                        }
                    }
                }
                if (sizeof($threads_arr) > 6) {
                    $threads_arr = array_slice($threads_arr, 0, 6);
                    $threads = collect($threads_arr);
                }

                // if threads_arr still < 7 => get mote from top thread
                $threads_top = $this->threadRepository->getThreadRecommend();
                if ($threads_top) {
                    foreach ($threads_top as $thread) {
                        if ($thread->user_id != auth()->id()) {
                            //check member
                            $is_member = 0;
                            foreach ($thread->members as $member)
                            {
                                if ($member->user_id == auth()->id()) {
                                    $is_member = 1;
                                }
                            }
                            if (!$is_member) {
                                $threads_arr[] = $thread;
                            }
                        }
                    }
                }
                $threads_arr = array_slice($threads_arr, 0, 6);
                $threads = collect($threads_arr);
            }

            // unset the same record
            $threads = $threads->unique('id');
        } else {
            // suggest with top threads
            $threads = $this->threadRepository->getThreadRecommend();
            if ($threads) {
                foreach ($threads as $thread) {
                    $threads_arr[] = $thread;
                }
            }
            if (sizeof($threads_arr) > 6) {
                $threads_arr = array_slice($threads_arr, 0, 6);
                $threads = collect($threads_arr);
            } else {
                $threads = collect($threads_arr);
            }
        }
        return $threads;
    }

    public function create()
    {
        $user = $this->userRepository->find(auth()->id());
        return view('posts.create', [
            'threads' => $user->threads ?? ''
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

        if ($data->thread_id && auth()->id()) {
            $this->userLogRepository->updateOrCreate($data->thread_id);
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
                $thread_id = $this->postRepository->find($request->post_id)->thread_id ?? '';
                if ($thread_id && auth()->id()) {
                    $this->userLogRepository->updateOrCreate($thread_id);
                }
                return response()->json(['success' => 'Comment has been saved']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
        return false;
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
            'data' => $data->post()->paginate(3) ?? '',
            'user' => $data ?? '',
        ]);
    }
}

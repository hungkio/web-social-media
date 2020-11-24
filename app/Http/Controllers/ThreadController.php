<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ThreadRepository;
use App\Http\Repositories\PostRepository;

class ThreadController extends Controller
{
    protected $categoryRepository;
    protected $threadRepository;
    protected $postRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ThreadRepository $threadRepository,
        PostRepository $postRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->threadRepository = $threadRepository;
        $this->postRepository = $postRepository;
    }

    public function index($category_id = 1)
    {
        $categories = $this->categoryRepository->getAll();
        $category = $this->categoryRepository->find($category_id);
        $threads = $this->threadRepository->getThreadTop($category_id);
        return view('threads.index', [
            'categories' => $categories ?? '',
            'threads' => $threads ?? '',
            'category_' => $category ?? '',
        ]);
    }

    public function create()
    {
        return 1;
    }

    public function store(Request $request)
    {
        return 1;
    }

    public function getPost($id)
    {
        $thread = $this->threadRepository->find($id);
        $posts = $thread->posts;
        if ($posts->isNotEmpty()) {
            $posts = $this->postRepository->diffTime($posts);
        }

        $is_join = 0;
        if ($thread->members->isNotEmpty()) {
            foreach ($thread->members as $member)
            {
                if ($member->user_id == auth()->id()) {
                    $is_join = 1;
                }
            }
        }
        return view('threads.home', [
            'data' => $posts ?? '',
            'thread' => $thread ?? '',
            'is_join' => $is_join,
        ]);
    }

    public function search(Request $request)
    {
        $key = $request->key ?? '';
        $html = '';
        $threads = $this->threadRepository->search($key, $request->user_id);
        if ($threads) {
            foreach ($threads as $thread)
            {
                $html .= '<a href="' . route('threads.post', $thread->id) .'"><h3>' . $thread->name . '</h3></a><hr>';
            }
        }
        if ($html == '') {
            $html = '<h3>No communities found</h3>';
        }
        return response()->json(['success' => $html]);
    }

    public function join(Request $request)
    {
        try {
            $this->threadRepository->join($request);
            return response()->json(['success' => 'Updated success']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getMyThread($category_id = 1)
    {
        $categories = $this->categoryRepository->getAll();
        $threads = $this->threadRepository->getThreadTop($category_id, auth()->id());
        return view('threads.my', [
            'categories' => $categories ?? '',
            'threads' => $threads ?? '',
        ]);
    }
}

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
            'category' => $category ?? '',
        ]);
    }

    public function post($id)
    {
        $thread = $this->threadRepository->find($id);
        $posts = $thread->posts;
        if ($posts->isNotEmpty()) {
            $posts = $this->postRepository->diffTime($posts);
        }
        return view('home', [
            'data' => $posts ?? ''
        ]);
    }
}

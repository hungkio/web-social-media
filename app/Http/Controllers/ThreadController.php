<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThreadRequest;
use App\ThreadMember;
use App\User;
use Illuminate\Http\Request;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ThreadRepository;
use App\Http\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\UserLogRepository;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateThreadRequest;

class ThreadController extends Controller
{
    protected $categoryRepository;
    protected $threadRepository;
    protected $postRepository;
    protected $userLogRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ThreadRepository $threadRepository,
        PostRepository $postRepository,
        UserLogRepository $userLogRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->threadRepository = $threadRepository;
        $this->postRepository = $postRepository;
        $this->userLogRepository = $userLogRepository;
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
        $categories = $this->categoryRepository->getAll();
        return view('threads.create', [
            'categories' => $categories
        ]);
    }

    public function edit($id)
    {
        $categories = $this->categoryRepository->getAll();
        $thread = $this->threadRepository->find($id);
        if ($thread->user_id == \auth()->id()) {
            return view('threads.update', [
                'categories' => $categories,
                'thread' => $thread,
            ]);
        }
        return back();
    }

    public function store(CreateThreadRequest $request)
    {
        $avatar = 'avatar.png';
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            // if size less than 150MB
            if ($file->getSize() < 150000000) {
                // upload
                $avatar = 'thread_avatar_' . Str::uuid() . "." . $file->getClientOriginalExtension();
                $file->storeAs("public/" . config('chatify.user_avatar.folder'), $avatar);
            } else {
                $msg = "File extension not allowed!";
                $error = 1;
            }
        }
        $data = $request->only('category_id', 'description', 'name');
        $data = array_merge($data, [
            'user_id' => auth()->id(),
            'avatar' => $avatar
        ]);
        try {
            $thread = $this->threadRepository->create($data);
            ThreadMember::create([
                'thread_id' => $thread->id,
                'user_id' => auth()->id(),
                'role' => ThreadMember::ADMIN,
                'status' => ThreadMember::APPROVED,
            ]);
            return redirect()->route('threads.my');
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update(UpdateThreadRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            // if size less than 150MB
            if ($file->getSize() < 150000000) {
                // upload
                $avatar = 'thread_avatar_' . Str::uuid() . "." . $file->getClientOriginalExtension();
                $file->storeAs("public/" . config('chatify.user_avatar.folder'), $avatar);
            } else {
                $msg = "File extension not allowed!";
                $error = 1;
            }
        }
        $data = $request->only('description', 'name');
        if (@$avatar) {
            $data = array_merge($data, [
                'avatar' => $avatar
            ]);
        }
        try {
            $thread = $this->threadRepository->update($request->id, $data);
            return redirect()->route('threads.my');
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function getPost($id)
    {
        $thread = $this->threadRepository->find($id);
        $posts = $thread->posts()->paginate(3);
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

    public function getPostAjax($id)
    {
        $thread = $this->threadRepository->find($id);
        $posts = $thread->posts()->paginate(3);
        $html = '';
        if ($posts->isNotEmpty()) {
            $posts = $this->postRepository->diffTime($posts);
        }
        foreach ($posts as $post)
        {
            $html .= view('post-component', [
                'post' => $post,
                'thread' => $thread,
            ]);
        }
        return response()->json(['data' => $html]);
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
            if ($request->thread_id && auth()->id() && $request->is_join) {
                $this->userLogRepository->updateOrCreate($request->thread_id);
            }
            return response()->json(['success' => 'Updated success']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getMyThread($category_id = 1)
    {
        $categories = $this->categoryRepository->getAll();
        $threads = $this->threadRepository->getMyThread($category_id);
        return view('threads.my', [
            'categories' => $categories ?? '',
            'threads' => $threads ?? '',
        ]);
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $this->threadRepository->find($id)->posts()->delete();
            $this->threadRepository->find($id)->votes()->delete();
            $this->threadRepository->find($id)->members()->delete();
            $this->threadRepository->delete($id);

            DB::commit();
            return redirect()->route('threads.my');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    // action for thread member
    public function manage($id)
    {
        $thread = $this->threadRepository->find($id);
        if ($thread->user_id == auth()->id()) {
            $members = ThreadMember::where('thread_id', $id)->get();
            return view('threads.manage', [
                'users' => $members,
                'admin_id' => $thread->user_id
            ]);
        }
    }

    public function deleteMember($id)
    {
        try {
            $thread_member = ThreadMember::findOrFail($id);
            $thread = $this->threadRepository->find($thread_member->thread_id);
            if ($thread_member->user_id != $thread->user_id) {
                $thread_member->delete();
            }
            return redirect()->route('threads.manage');
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function changeApprove($id, $status)
    {
        try {
            $thread_member = ThreadMember::findOrFail($id);
            $thread = $this->threadRepository->find($thread_member->thread_id);
            if ($thread_member->user_id != $thread->user_id) {
                if ($status == ThreadMember::APPROVED) {
                    $thread_member->update(['status' => ThreadMember::APPROVED]);
                } else {
                    $thread_member->update(['status' => ThreadMember::DISAPPROVED]);
                }
            }
            return redirect()->route('threads.manage');
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }
}

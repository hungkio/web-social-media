<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use App\Http\Repositories\VoteRepository;
use App\Http\Repositories\PostRepository;

class VoteController extends Controller
{
    protected $voteRepository;
    protected $postRepository;

    public function __construct(
        VoteRepository $voteRepository,
        PostRepository $postRepository
    )
    {
        $this->voteRepository = $voteRepository;
        $this->postRepository = $postRepository;
    }

    public function update(Request $request)
    {
        if (isset($request->vote)) {
            $data = [
                'user_id' => auth()->id(),
                'post_id' => $request->post_id,
                'type' => $request->vote
            ];

            if ($request->comment_id) {
                $data = array_merge($data, ['comment_id' => $request->comment_id]);
            }

            $post = $this->postRepository->find($request->post_id);
            $data = array_merge($data, ['thread_id' => $post->thread_id]);

            $this->voteRepository->updateOrCreate($data);
        }
    }
}

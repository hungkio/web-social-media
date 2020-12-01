<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use App\Http\Repositories\VoteRepository;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserLogRepository;

class VoteController extends Controller
{
    protected $voteRepository;
    protected $postRepository;
    protected $userLogRepository;

    public function __construct(
        VoteRepository $voteRepository,
        PostRepository $postRepository,
        UserLogRepository $userLogRepository
    )
    {
        $this->voteRepository = $voteRepository;
        $this->postRepository = $postRepository;
        $this->userLogRepository = $userLogRepository;
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
            if ($request->vote == Vote::UP_VOTE) {
                $post->update(['up_vote' => ++$post->up_vote]);
                if ($post->thread_id && auth()->id()) {
                    $this->userLogRepository->updateOrCreate($post->thread_id);
                }
            }
            if ($request->vote == Vote::REMOVE_VOTE && $post->up_vote > 0) {
                $post->update(['up_vote' => --$post->up_vote]);
            }
            $data = array_merge($data, ['thread_id' => $post->thread_id]);

            $this->voteRepository->updateOrCreate($data);
        }
    }
}

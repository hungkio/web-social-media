<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use App\Http\Repositories\VoteRepository;

class VoteController extends Controller
{
    protected $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
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

            $this->voteRepository->updateOrCreate($data);
        }
    }
}
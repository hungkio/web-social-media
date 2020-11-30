<?php

namespace App\Http\Repositories;

use App\Vote;

class VoteRepository
{
    public function updateOrCreate($data)
    {
        if (isset($data['comment_id'])) {
            return Vote::updateOrCreate(
                [
                    'post_id' => $data['post_id'],
                    'comment_id' => $data['comment_id'],
                    'user_id' => $data['user_id'],
                    'thread_id' => $data['thread_id'],
                ],
                [
                    'type' => $data['type']
                ]
            );
        } else {
            return Vote::updateOrCreate(
                [
                    'post_id' => $data['post_id'],
                    'user_id' => $data['user_id'],
                    'thread_id' => $data['thread_id'],
                ],
                [
                    'type' => $data['type']
                ]
            );
        }
    }

    public function getMyVote($post_id, $comment_id)
    {
        $query = Vote::where('user_id', auth()->id())->where('post_id', $post_id);
        if (isset($comment_id)) {
            $query->where('comment_id', $comment_id);
        }
        return $query->get();
    }
}

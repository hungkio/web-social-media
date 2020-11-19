<?php

namespace App\Http\Repositories;

use App\Comment;

class CommentRepository
{
    public function formatComment($comments)
    {
        $comments_arr = [];
        foreach ($comments as $comment)
        {
            $comment_sub_arr = [];
            foreach ($comments as $sub_comment)
            {
                if ($sub_comment->parent == $comment->id) {
                    $comment_sub_arr[] = $sub_comment;
                }
            }
            $comment->sub_comment = collect($comment_sub_arr);

            if (!$comment->parent) {
                $comments_arr[] = $comment;
            }
        }
        return collect($comments_arr);
    }

    public function store($data)
    {
        return Comment::create($data);
    }
}

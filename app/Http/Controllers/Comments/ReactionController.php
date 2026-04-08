<?php

namespace App\Http\Controllers\Comments;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\CommentReaction;

class ReactionController
{
    /**
     * Like a comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like_store(Comment $comment)
    {
        $reaction = CommentReaction::where('user_id', auth()->id())->where('comment_id', $comment->id)->first();

        if ($reaction) {
            $reaction->delete();
            return back()->with('success', 'You removed your like to this comment.');
        } else {
            $reaction = new CommentReaction();
            $reaction->user_id = auth()->id();
            $reaction->comment_id = $comment->id;
            $reaction->type = 1;
            $reaction->save();
        }

        return back()->with('success', 'You liked the comment.');
    }

    /**
     * Dislike a comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dislike_store(Comment $comment)
    {
        $reaction = CommentReaction::where('user_id', auth()->id())->where('comment_id', $comment->id)->first();

        if ($reaction) {
            $reaction->delete();
            return back()->with('success', 'You removed your dislike to this comment.');
        } else {
            $reaction = new CommentReaction();
            $reaction->user_id = auth()->id();
            $reaction->comment_id = $comment->id;
            $reaction->type = 0;
            $reaction->save();
        }

        return back()->with('success', 'You disliked the comment.');
    }
}

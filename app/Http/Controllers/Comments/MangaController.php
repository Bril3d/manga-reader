<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\Comment;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct()
    {
        $this->middleware('can:delete,comment')->only('delete');
    }

    /**
     * Add a comment to a manga.
     *
     * @param  \App\Models\Manga  $manga
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Manga $manga, Request $request)
    {
        $request->validate([
            'content' => 'required|min:10|max:500',
        ]);

        // Create a new comment
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->commentable_type = Manga::class;
        $comment->commentable_id = $manga->id;
        $comment->save();

        // Redirect back or perform any other actions
        return back()->with('success', 'Comment has been commented!');
    }

    /**
     * Delete a manga comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'comment_id' => 'required',
        ]);

        $commentId = $request->input('comment_id');
        $comment = Comment::findOrFail($commentId);

        if ($comment) {
            $comment->delete();

            return back()->with('success', 'Comment deleted successfully!');
        }

        return back()->with('error', 'Failed to delete the comment!');
    }
}

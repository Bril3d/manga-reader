<?php

namespace App\Http\Controllers\Comments;

use App\Models\Manga;
use App\Models\Comment;
use Illuminate\Http\Request;

class ChapterController
{
    /**
     * Add a comment to a chapter of a manga.
     *
     * @param  \App\Models\Manga  $manga
     * @param  int  $chapterNumber
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Manga $manga, $chapterNumber, Request $request)
    {
        $chapterData = $manga->chapters()->where('chapter_number', $chapterNumber)->first();

        if (!$chapterData) {
            abort('404');
        }

        $request->validate([
            'content' => 'required|min:10|max:500',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->commentable_type = 'App\Models\Chapter';
        $comment->commentable_id = $chapterData->id;
        $comment->save();

        return back()->with('success', 'Comment has been commented!');
    }

    /**
     * Delete a chapter comment.
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
        $comment = Comment::find($commentId);

        $this->authorize('delete', $comment);

        if ($comment) {
            $comment->delete();

            return back()->with('success', 'Comment deleted successfully!');
        }

        return back()->with('error', 'Failed to delete the comment!');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct()
    {
        $this->middleware('can:viewAny,' . Comment::class)->only('index');
        $this->middleware('can:create,' . Comment::class)->only(['create', 'store']);
        $this->middleware('can:update,comment')->only(['edit', 'update']);
        $this->middleware('can:delete,comment')->only('delete');
    }

    /**
     * Get the list of comments.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $commentsQuery = Comment::query();

        if ($request->filled('content')) {
            $content = $request->input('content');

            $commentsQuery->where('content', 'LIKE', '%' . $content . '%');
        }

        $comments = $commentsQuery->latest()->fastPaginate(20);

        return view('dashboard.comments.index', compact('comments'));
    }

    /**
     * Edit a comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\View\View
     */
    public function edit(Comment $comment)
    {
        return view('dashboard.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment.
     *
     * @param  \App\Models\Comment  $comment
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Comment $comment, Request $request)
    {
        $request->validate([
            'content' => ['required'],
        ]);

        $comment->update(['content' => $request->input('content')]);

        return back()->with('success', __('Comment has been updated'));
    }


    /**
     * Delete the specified comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', __('Comment has been deleted'));
    }
}

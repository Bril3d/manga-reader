@section('title', __('Comments List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Comments List'),
    'has_search' => true,
    'search_name' => 'content',
    'search_link' => route('dashboard.comments.index'),
    'search_placeholder' => __('Search for comment...'),
    ])

    <x-table :headings="['#', __('Username'), __('Comment'), __('Source'), __('Likes'), __('Dislikes')]" :contents="
                $comments->map(function ($comment) {
                    
                    $commentable = $comment->commentable;
                    $source = match (class_basename($commentable)) {
                        'Manga' => __('Manga') . ' - ' . $commentable->title,
                        'Chapter' => __('Chapter') . ' ' . $commentable->chapter_number . ' - Manga ' . $commentable->manga->title,
                        default => null,
                    };
    
                    return [
                        $comment->id,
                        $comment->user->username,
                        $comment->content,
                        $source,
                        $comment->likes->count(),
                        $comment->dislikes->count(),
                        'edit' => route('dashboard.comments.edit', $comment->id),
                        'delete' => route('dashboard.comments.delete', $comment->id)
                    ];
                })->toArray()" />
    <div class="flex justify-end">
        {{ $comments->links('pagination.default') }}
    </div>
</div>
@endsection

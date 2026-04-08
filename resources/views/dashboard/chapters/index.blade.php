@section('title', __('Chapters List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Chapters List'),
    'has_search' => true,
    'search_link' => route('dashboard.chapters.index'),
    'search_placeholder' => __('Search for chapter...'),
    ])

    <x-table :headings="['#', __('Chapter number'), __('Manga'), __('Uploader'), __('Views')]" :contents="
                $chapters->map(function ($chapter) {
                    return [
                        $chapter->id,
                        $chapter->chapter_number,
                        $chapter->manga->title,
                        $chapter->user->username,
                        $chapter->views->count(),
                        'edit' => route('dashboard.chapters.edit', $chapter->id),
                        'delete' => route('dashboard.chapters.delete', $chapter->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $chapters->links('pagination.default') }}
    </div>
</div>
@endsection

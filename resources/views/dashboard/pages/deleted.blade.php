@section('title', __('Pages List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Pages List'),
    'has_search' => true,
    'search_link' => route('dashboard.pages.deleted'),
    'search_placeholder' => __('Search for page...'),
    ])


    <x-table :headings="['#', __('Title'), __('Slug'), __('Creator'), __('Views')]" :contents="
                $pages_pagination->map(function ($page) {
                    return [
                        $page->id,
                        $page->title,
                        $page->slug,
                        $page->user->username,
                        $page->views->count(),
                        'restore' => route('dashboard.pages.restore', $page->id),
                        'delete' => route('dashboard.pages.hard_delete', $page->id)

                    ];
                })->toArray()" />
    <div>
        {{ $pages_pagination->links('pagination.default') }}
    </div>
</div>
@endsection

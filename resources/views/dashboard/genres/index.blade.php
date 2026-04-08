@section('title', __('Genres List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Genres List'),
    'has_search' => true,
    'search_link' => route('dashboard.genres.index'),
    'search_placeholder' => __('Search for genre...'),
    ])

    <x-table :headings="[ '#', __('Name'), __('Slug')]" :contents="
                $genres->map(function ($genre) {
                    return [
                        $genre->id,
                        $genre->title,
                        $genre->slug,
                        'edit' => route('dashboard.genres.edit', $genre->id),
                        'delete' => route('dashboard.genres.delete', $genre->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $genres->links('pagination.default') }}
    </div>
</div>
@endsection

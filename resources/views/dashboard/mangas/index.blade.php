@section('title', __('Mangas List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Mangas List'),
    'has_search' => true,
    'search_link' => route('dashboard.mangas.index'),
    'search_placeholder' => __('Search for manga...'),
    ])

    <x-table :headings="['#', __('Title'), __('Slug'), __('Description'), __('Uploader'), __('Views')]" :contents="
                $mangas->map(function ($manga) {
                    return [
                        $manga->id,
                        $manga->title,
                        $manga->slug,
                        \Illuminate\Support\Str::limit(strip_tags($manga->description), 50, $end = '...'),
                        $manga->user->username,
                        $manga->views->count(),
                        'edit' => route('dashboard.mangas.edit', $manga->id),
                        'delete' => route('dashboard.mangas.delete', $manga->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $mangas->links('pagination.default') }}
    </div>
</div>
@endsection

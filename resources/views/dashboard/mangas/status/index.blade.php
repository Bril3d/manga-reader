@section('title', __('Manga Status List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Mangas Status List'),
    'has_search' => true,
    'search_link' => route('dashboard.mangas_status.index'),
    'search_placeholder' => __('Search for status...'),
    ])

    <x-table :headings="['#', __('Title'), __('Slug')]" :contents="
                $statuses->map(function ($status) {
                    return [
                        $status->id,
                        $status->title,
                        $status->slug,
                        'edit' => route('dashboard.mangas_status.edit', $status->id),
                        'delete' => route('dashboard.mangas_status.delete', $status->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $statuses->links('pagination.default') }}
    </div>
</div>
@endsection

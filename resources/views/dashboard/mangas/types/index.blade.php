@section('title', __('Manga Types List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Manga Types List'),
    'has_search' => true,
    'search_link' => route('dashboard.mangas_types.index'),
    'search_placeholder' => __('Search for type...'),
    ])

    <x-table :headings="['#', __('Title'), __('Slug')]" :contents="
                $types->map(function ($type) {
                    return [
                        $type->id,
                        $type->title,
                        $type->slug,
                        'edit' => route('dashboard.mangas_types.edit', $type->id),
                        'delete' => route('dashboard.mangas_types.delete', $type->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $types->links('pagination.default') }}
    </div>
</div>
@endsection

@section('title', __('Ads List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Ads List'),
    'search_name' => 'name',
    'has_search' => true,
    'search_link' => route('dashboard.ads.index'),
    'search_placeholder' => __('Search for ad...'),
    ])

    <x-table :headings="[ '#', __('Name'), __('Identifier'), __('Status'), __('Type'), __('Clicks')]" :contents="
                $ads->map(function ($ad) {
                    return [
                        $ad->id,
                        $ad->name,
                        $ad->identifier,
                        $ad->type,
                        $ad->is_active ? __('Active') : __('Disabled'),
                        $ad->views->count(),
                        'edit' => route('dashboard.ads.edit', $ad->id),
                        'delete' => route('dashboard.ads.delete', $ad->id)
                    ];
                })->toArray()
            " />

    <div class="flex justify-end">
        {{ $ads->links('pagination.default') }}
    </div>
</div>
@endsection

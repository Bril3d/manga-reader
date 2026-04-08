@section('title', __('Menus List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Menus List'),
    'has_search' => true,
    'search_name' => 'name',
    'search_link' => route('dashboard.menus.index'),
    'search_placeholder' => __('Search for menu...'),
    ])

    <x-table :headings="['#', __('Name'), __('Slug / Identifier'), __('Created At')]" :contents="
                $menus->map(function ($menu) {
                    return [
                        $menu->id,
                        $menu->name,
                        $menu->slug,
                        $menu->created_at,
                        'edit' => route('dashboard.users.edit', $menu->id),
                        'delete' => route('dashboard.users.delete', $menu->id)
                    ];
                })->toArray()" />
    <div class="flex justify-end">
        {{ $menus->links('pagination.default') }}
    </div>

</div>
@endsection

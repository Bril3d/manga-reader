@section('title', __('Roles List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Roles List'),
    'has_search' => true,
    'search_name' => 'name',
    'search_link' => route('dashboard.roles.index'),
    'search_placeholder' => __('Search for role...'),
    ])

    <x-table :headings="['#', __('Role Name'), __('Created At'), __('Updated At')]" :contents="
                $roles->map(function ($role) {
                    return [
                        $role->id,
                        $role->name,
                        $role->created_at,
                        $role->updated_at,
                        'edit' => route('dashboard.roles.edit', $role->id),
                        'delete' => route('dashboard.roles.delete', $role->id)
                    ];
                })->toArray()" />
    <div class="flex justify-end">
        {{ $roles->links('pagination.default') }}
    </div>
</div>
@endsection

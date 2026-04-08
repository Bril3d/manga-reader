@section('title', __('Users List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Users List'),
    'has_search' => true,
    'search_name' => 'username',
    'search_link' => route('dashboard.users.index'),
    'search_placeholder' => __('Search for user...'),
    ])

    <x-table :headings="['#', __('Username'), __('Email'), __('Roles'), __('Registered')]" :contents="
                $users->map(function ($user) {
                    $roles = $user->getRoleNames()->toArray();
                    return [
                        $user->id,
                        $user->username,
                        $user->email,
                        implode(', ', $roles),
                        $user->created_at,
                        'edit' => route('dashboard.users.edit', $user->id),
                        'delete' => route('dashboard.users.delete', $user->id)
                    ];
                })->toArray()" />
    <div class="flex justify-end">
        {{ $users->links('pagination.default') }}
    </div>
</div>
@endsection

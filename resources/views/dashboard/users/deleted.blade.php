@section('title', __('Users List'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', [
    'title' => __('Users List'),
    'has_search' => true,
    'search_name' => 'username',
    'search_link' => route('dashboard.users.deleted'),
    'search_placeholder' => __('Search for user...'),
    ])

    <x-table :headings="['#', __('Username'), __('Email'), __('Roles'), __('Registered')]" :contents="
                $users->map(function ($user) {
                    return [
                        $user->id,
                        $user->username,
                        $user->email,
                        implode(', ', $user->getRoleNames()->toArray()),
                        $user->created_at,
                        'restore' => route('dashboard.users.restore', $user->id),
                        'delete' => route('dashboard.users.hard_delete', $user->id)
                    ];
                })->toArray()" />
    <div class="flex justify-end">
        {{ $users->links('pagination.default') }}
    </div>
</div>
@endsection

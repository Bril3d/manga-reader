@section('title', __('Edit User (:username)', ['username' => $user->username]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit User (:username)', ['username' => $user->username])])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.group>
            <x-form.input label="{{ __('Username') }}" name="username" :value="old('username', $user->username)" />
            <x-form.input label="{{ __('Email') }}" name="email" type="email" :value="old('email', $user->email)" />
        </x-form.group>

        <x-form.input label="{{ __('Description') }}" name="description" :value="old('description', $user->description)" />

        <x-form.select label="{{ __('Roles') }}" name="roles[]" :selected="old('roles', $user->roles->pluck('name')->toArray())" :options="App\Models\Role::all()->pluck('name', 'name')" multiple></x-form.select>

        <x-form.label title="{{__('Leave blank if you do not want to change the password')}}" />
        <x-form.group>
            <x-form.input label="{{ __('Password') }}" type="password" name="password" />
            <x-form.input label="{{ __('Password Confirmation') }}" type="password" name="password_confirmation" />
        </x-form.group>

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

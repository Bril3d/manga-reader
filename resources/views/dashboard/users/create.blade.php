@section('title', __('Add New User'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New User')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf

        <x-form.group>
            <x-form.input name="username" :value="old('username')" placeholder="{{ __('Username') }}" />
            <x-form.input name="email" type="email" :value="old('email')" placeholder="{{ __('Email') }}" />
        </x-form.group>

        <x-form.group>
            <x-form.input type="password" name="password" :value="old('password')" placeholder="{{ __('Password') }}" />
            <x-form.input type="password" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}" />
        </x-form.group>

        <x-form.input name="description" :value="old('description')" placeholder="{{ __('Description') }}" />

        <x-form.select label="{{ __('Roles') }}" name="roles[]" :selected="old('roles', [])" :options="App\Models\Role::all()->pluck('name', 'name')" multiple></x-form.select>

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

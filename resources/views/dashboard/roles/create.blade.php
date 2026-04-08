@section('title', __('Add New Role'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Role')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.roles.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <x-form.input name="name" :value="old('name')" placeholder="{{__('Role Name')}}" />
        <x-form.select class="min-h-[20rem]" label="{{ __('Permissions') }}" name="permissions[]" :selected="old('permissions', [])" :options="Spatie\Permission\Models\Permission::all()->pluck('name', 'id')" multiple></x-form.select>

        <x-button.primary>{{ __('Search') }}</x-button.primary>
    </form>
</div>
@endsection

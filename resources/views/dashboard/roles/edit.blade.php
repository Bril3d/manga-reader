@section('title', __('Edit Role (:role)', ['role' => $role->name]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Role (:role)', ['role' => $role->name])])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.input label="{{__('Role Name')}}" name="name" :value="old('name', $role->name)" />
        <x-form.select class="min-h-[20rem]" label="{{ __('Permissions') }}" name="permissions[]" :selected="old('permissions', $role->permissions->pluck('id')->toArray())" :options="Spatie\Permission\Models\Permission::all()->pluck('name', 'id')" multiple></x-form.select>

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

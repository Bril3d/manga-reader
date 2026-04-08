@section('title', __('Edit Manga Type (:name)', ['name' => $type->title]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Manga Type (:name)', ['name' => $type->title])])
    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_types.update', $type->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')
        <x-form.input id="title" name="title" :value="old('name', $type->title)" placeholder="{{ __('Type Name') }}" />
        <x-form.input id="slug" name="slug" :value="old('slug', $type->slug)" placeholder="{{ __('Type Slug') }}" />
        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

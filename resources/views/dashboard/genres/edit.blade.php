@section('title', __('Edit Genre (:name)', ['name' => $genre->title]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Genre (:name)', ['name' => $genre->title])])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.genres.update', $genre->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.input id="title" name="title" :value="old('name', $genre->title)" placeholder="{{ __('Genre Name') }}" />
        <x-form.input id="slug" name="slug" :value="old('slug', $genre->slug)" placeholder="{{ __('Genre Slug') }}" />
        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

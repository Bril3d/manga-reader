@section('title', __('Edit Page - :title', ['title' => $page->title]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold dark:text-white">
                {{ __('Edit Page - :title', ['title' => $page->title]) }}
            </h1>
        </div>
    </div>

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.pages.update', $page->id) }}" method="POST" id="form-editor" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <input type="hidden" name="content" id="content" value="{{ old('content', $page->content) }}">

        <x-form.group>
            <x-form.input name="title" :value="old('title', $page->title)" placeholder="{{ __('Page Title') }}" />
            <x-form.input name="slug" :value="old('slug', $page->slug)" placeholder="{{ __('Page Slug') }}" />
        </x-form.group>

        <x-form.label title="{{ __('Page Content') }}" />
        <div id="editor"></div>

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@vite(['resources/js/editor.js'])
@endsection

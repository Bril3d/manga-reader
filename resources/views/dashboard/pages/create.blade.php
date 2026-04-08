@section('title', __('Add New Page'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold dark:text-white">
                {{ __('Add New Page') }}
            </h1>
        </div>
    </div>

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.pages.store') }}" method="POST" id="form-editor" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf

        <input type="hidden" name="content" id="content" value="{{ old('content') }}">

        <x-form.group>
            <x-form.input id="title" name="title" :value="old('title')" placeholder="{{ __('Page Title') }}" />
            <x-form.input id="slug" name="slug" :value="old('slug')" placeholder="{{ __('Page Slug') }}" />
        </x-form.group>

        <x-form.label title="{{ __('Page Content') }}" />
        <div id="editor"></div>
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>
@vite(['resources/js/editor.js'])
@endsection

@section('title', __('Edit Manga Status (:name)', ['name' => $status->title]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Manga Status (:name)', ['name' => $status->title])])
    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_status.update', $status->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')
        <x-form.input id="title" name="title" :value="old('name', $status->title)" placeholder="{{ __('Status Name') }}" />
        <x-form.input id="slug" name="slug" :value="old('slug', $status->slug)" placeholder="{{ __('Status Slug') }}" />
        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

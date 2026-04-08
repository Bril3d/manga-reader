@section('title', __('Add New Genre'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Genre')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.genres.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <x-form.input id="title" name="title" :value="old('title')" placeholder="{{ __('Genre Name') }}" />
        <x-form.input id="slug" name="slug" :value="old('slug')" placeholder="{{ __('Genre Slug') }}" />
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>
@endsection

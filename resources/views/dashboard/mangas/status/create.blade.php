@section('title', __('Add New Manga Status'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Manga Status')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_status.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <x-form.input id="title" name="title" :value="old('title')" placeholder="{{ __('Status Name') }}" />
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>
@endsection

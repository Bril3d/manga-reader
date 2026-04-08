@section('title', __('Add New Manga Type'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Manga Type')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_types.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <x-form.input id="title" name="title" :value="old('title')" placeholder="{{ __('Type Name ex. Manga') }}" />
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>
@endsection

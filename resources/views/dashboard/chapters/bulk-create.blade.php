@section('title', __('Bulk Add Chapters'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Bulk Add Chapters')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.chapters.bulk_store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">

        @csrf

        @php
        $mangasEl = json_decode($mangas, true);
        $mangasEl = $mangasEl ? array_column($mangasEl, 'title', 'id') : [];
        @endphp

        <x-form.select label="{{ __('Manga') }}" name="manga_id" selected="{{ old('manga_id') }}" :options="$mangasEl"></x-form.select>

        <div class="relative">
            <x-form.label title="{{ __('Zip file - Containing FOLDERS with chapter number as folder name') }}" />
            <div id="dropzone" class="bg-input dropzone"></div>

            {{-- <x-form.input type="file" name="images" /> --}}
        </div>

        <x-button.primary>{{ __('Submit') }}</x-button.primary>

    </form>
</div>
<script>
    const uploadUrl = "{{ route('dashboard.chapters.bulk_store') }}";
    const urlRedirect = "{{ route('dashboard.chapters.bulk_create') }}";
    const csrfToken = "{{ csrf_token() }}";

</script>

@vite(['resources/js/chunks.js','resources/css/dropzone.css'])

@endsection

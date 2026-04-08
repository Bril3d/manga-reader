@section('title', __('Add New Chapter'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Chapter')])
    <x-alert.error :errors="$errors" />

    @if(count($mangas) === 0)
    <x-alert.info>
        {{ __('There is no mangas yet, add some and try again.') }}
    </x-alert.info>
    @else
    <form action="{{ route('dashboard.chapters.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4" id="chapter-form">
        @csrf
        @php
        @endphp
        <x-form.group>
            <x-form.select label="{{ __('Manga') }}" name="manga_id" selected="{{ old('manga_id') }}" :options="$mangas"></x-form.select>
            <x-form.input name="chapter_number" :value="old('chapter_number')" placeholder="{{ __('Chapter Number') }}" />
        </x-form.group>

        <x-form.select id="upload-type" label="{{ __('Upload Type') }}" name="upload_type" selected="{{ old('type') }}" :options="['images' => __('Images'), 'zip' => __('ZIP')]"></x-form.select>

        <div id="images-upload">
            <div class="input-div py-20 border-[1px] border-black/10 dark:bg-input rounded-md flex flex-col items-center relative ">
                <p>{{ __('Drag & drop photos here or') }} <strong>{{ __('Browse') }}</strong></p>
                <x-form.input id="images" label="{{ __('You chapter images - images need to be in order') }}" class="absolute left-0 bottom-0 h-full opacity-0 cursor-pointer" type="file" name="images[]" accept="image/jpeg, image/png, image/jpg, image/webp" multiple />
            </div>
        </div>

        <div id="zip-upload" class="hidden">
            <x-form.input label="{{ __('Zip file - Containing all images in order') }}" type="file" name="file" />
        </div>

        <div id="progress-bar-container" class="hidden w-full bg-gray-200 rounded-full h-7 dark:bg-gray-700">
            <div id="progress-bar" class="bg-blue-600 h-7 rounded-full"></div>
        </div>
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
    <div id="images-preview" class="sortable-images flex flex-wrap gap-3"></div>
    @endif
</div>
<script>
    const uploadUrl = "{{ route('dashboard.chapters.store') }}";
    const urlRedirect = "{{ route('dashboard.chapters.create') }}";
    const csrfToken = "{{ csrf_token() }}";

</script>
@vite(['resources/js/dashboard/chapter.js'])
@endsection

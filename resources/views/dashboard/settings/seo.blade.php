@section('title', __('Edit SEO Settings'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit SEO Settings')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_seo') }}" method="POST" class="flex flex-col gap-3">
        @csrf
        @method('PUT')

        <div class="bg-input/20 border-[1px] border-black/10 dark:border-white/10 px-6 py-3 rounded-md">
            <h2 class="font-semibold">{{ __('Single Manga SEO') }}</h2>
            <span class="text-sm text-black dark:text-white !text-opacity-60">{{ __('Use :title as a placeholder for the real manga title') }}</span>
        </div>
        <x-form.input label="{{__('Manga Title')}}" name="manga-title" :value="old('manga-title', settings()->get('seo.manga.title'))" />
        <x-form.input label="{{__('Manga Description')}}" name="manga-description" :value="old('manga-description', settings()->get('seo.manga.description'))" />

        <div class="bg-input/20 border-[1px] border-black/10 dark:border-white/10 px-6 py-3 rounded-md mt-2">
            <h2 class="font-semibold">{{ __('Single Chapter SEO') }}</h2>
            <span class="text-sm text-black dark:text-white !text-opacity-60">{{ __('Use :manga as a placeholder for the real manga title and :chapter for chapter number') }}</span>
        </div>
        <x-form.input label="{{__('Chapter Title')}}" name="chapter-title" :value="old('chapter-title', settings()->get('seo.chapter.title'))" />
        <x-form.input label="{{__('Chapter Description')}}" name="chapter-description" :value="old('chapter-description', settings()->get('seo.chapter.description'))" />


        <div class="bg-input/20 border-[1px] border-black/10 dark:border-white/10 px-6 py-3 rounded-md mt-2">
            <h2 class="font-semibold">{{ __('Manga List SEO') }}</h2>
        </div>
        <x-form.input label="{{__('Manga List Title')}}" name="mangas-title" :value="old('mangas-title', settings()->get('seo.mangas.title'))" />
        <x-form.input label="{{__('Manga List Description')}}" name="mangas-description" :value="old('mangas-description', settings()->get('seo.mangas.description'))" />


        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

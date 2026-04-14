@section('title', strtr(settings()->get('seo.chapter.title'), [':manga' => $manga->title, ':chapter' => $chapter->chapter_number]))
@section('description', strtr(settings()->get('seo.chapter.description'), [':manga' => $manga->title, ':chapter' => $chapter->chapter_number]))
@extends('layout')
@section('content')
<section class="flex flex-col items-center">
    <h2 class="text-lg font-bold">
        {{ __(':manga - Chapter', ['manga' => $manga->title, 'chapter' => $chapter->chapter_number]) }}
    </h2>
    <span class="text-on-surface-variant/60 text-xs">
        {{ __('All chapter are in') }}
        <a class="text-on-surface-variant hover:text-neon-purple duration-200 transition-all" href="{{ url('/manga/' . $manga->slug) }}">{{ $manga->title }}</a>
    </span>
    <div class="flex flex-col gap-4 sm:flex-row bg-surface-container-low border border-outline-variant/30 shadow-md rounded-2xl my-5 py-4 px-6 sm:justify-between sm:items-center w-full lg:w-4/5">
        <div class="flex flex-col items-start">
            <h3 class="text-md text-on-surface-variant font-bold hover:text-neon-purple duration-200 transition-all">
                <a href="{{ url('/manga/' . $manga->slug) }}">{{ $manga->title }}</a>
            </h3>

            <span class="block">
                {{ __(':manga - Chapter :chapter', ['manga' => $manga->title, 'chapter' => $chapter->chapter_number]) }}
            </span>
        </div>

        <div class="w-full sm:w-1/3">
            <x-form.select id="chapter-select" name="type" selected="{{ $chapter->chapter_number }}" :options="$options"></x-form.select>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @include('components.chapter.button', ['chapter' => $prevChapter, 'slug' => $manga->slug, 'text' => __('Previous'), 'type' => 'prev' ])
            @include('components.chapter.button', ['chapter' => $nextChapter, 'slug' => $manga->slug, 'text' => __('Next'), 'type' => 'next' ])
        </div>
    </div>



    <div class="max-w-3xl mx-auto">
        <x-ads.main identifier="above-images-chapter" />
        @foreach ($chapter->content as $image)
        <img class="lazyload w-full chapter-image cursor-pointer" data-src="{{ str_contains($image, '/') ? asset('storage/' . $image) : asset('storage/content/'.$manga->slug.'/'.$chapter->chapter_number.'/'.$image) }}" alt="{{ $manga->title }} - {{ $chapter->chapter_number }} - {{ $image }}" />
        @endforeach
        <x-ads.main identifier="below-images-chapter" />
    </div>

    <div class="flex flex-col gap-4 sm:flex-row bg-surface-container-low border border-outline-variant/30 shadow-md rounded-2xl my-5 py-4 px-6 sm:justify-between sm:items-center w-full lg:w-4/5">
        <div class="flex flex-col items-start">
            <h3 class="text-md text-on-surface-variant font-bold hover:text-neon-purple duration-200 transition-all">
                <a href="{{ url('/manga/' . $manga->slug) }}">{{ $manga->title }}</a>
            </h3>

            <span class="block">
                {{ __(':manga - Chapter :chapter', ['manga' => $manga->title, 'chapter' => $chapter->chapter_number]) }}
            </span>
        </div>

        <div class="w-full sm:w-1/3">
            <x-form.select id="chapter-select" name="type" selected="{{ $chapter->chapter_number }}" :options="$options"></x-form.select>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @include('components.chapter.button', ['chapter' => $prevChapter, 'slug' => $manga->slug, 'text' => __('Previous'), 'type' => 'prev' ])
            @include('components.chapter.button', ['chapter' => $nextChapter, 'slug' => $manga->slug, 'text' => __('Next'), 'type' => 'next' ])
        </div>
    </div>

    <div class="container mx-auto px-3 sm:px-0 md:px-0 mt-10 flex justify-center">
        <div id="comments-list" class="w-full lg:w-3/4">
            @include('comments.index', [
            'comments' => $chapter->comments,
            'model' => $chapter,
            'modelType' => 'chapter',
            ])
        </div>
    </div>
</section>
@endsection

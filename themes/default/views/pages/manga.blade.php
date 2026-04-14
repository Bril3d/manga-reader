@section('title', str_replace(':title', $manga->title, settings()->get('seo.manga.title')))
@section('description', str_replace(':title', $manga->title, settings()->get('seo.manga.description')))
@extends('layout')
@section('content')
<section>
    <div class="flex flex-col sm:flex-row md:flex-row lg:flex-row gap-6">
        <div class="w-full sm:w-72 md:w-80 lg:w-96 rounded-lg flex flex-col gap-3">
            <div class="relative">
                <div class="sm:hidden absolute -bottom-1 inset-0 bg-gradient-to-b from-transparent to-surface"></div>
                <img class="object-cover object-bottom w-full h-full sm:max-h-[300px] md:max-h-[400px] rounded-lg" src="{{ asset('storage/covers/' . $manga->cover) }}" alt="{{ $manga->title }}">
            </div>
            <x-manga.buttons :firstChapter="$firstChapter" :slug="$manga->slug" :id="$manga->id" />
            <div class="hidden sm:flex sm:flex-col sm:gap-1 sm:text-sm">
                <x-manga.info text="{{ __('Status') }}" :info="$manga->status()->first()->title ?? '-'" :search="$manga->status()->first() ? 'status=' . $manga->status()->first()->slug : null" />
                <x-manga.info text="{{ __('Type') }}" :info="$manga->types()->first()->title ?? '-'" :search="$manga->types()->first() ? 'type=' . $manga->types()->first()->slug : null" />
                <x-manga.info text="{{ __('Year') }}" :info="$manga->releaseDate" />
                <x-manga.info text="{{ __('Author') }}" :info="$manga->author ?? '-'" />
                <x-manga.info text="{{ __('Artist') }}" :info="$manga->artist ?? '-'" />
                <x-manga.info text="{{ __('Posted') }}" :info="$manga->user->username ?? '-'" />
            </div>
        </div>
        <div class="w-full">
            <x-ads.main identifier="above-title-manga" />
            <div class="flex mt-3 gap-1 md:gap-2 mb-3">
                <x-share.facebook link="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('manga.show', $manga->id)) }}" />
                <x-share.twitter link="https://twitter.com/intent/tweet?url={{ urlencode(route('manga.show', $manga->id)) }}" />
                <x-share.pinterest link="https://www.pinterest.com/pin/create/button?url={{ urlencode(route('manga.show', $manga->id)) }}" />
                <x-share.whatsapp link="whatsapp://send?text={{ urlencode(route('manga.show', $manga->id)) }}" />
            </div>
            <h2 class="text-2xl font-bold leading-[1.5rem]">{{ $manga->title }} <span class="capitalize text-sm text-on-surface-variant/50">[{{ $manga->types()->first()->title ?? '-' }}]</span></h2>
            <span class="text-on-surface-variant block mt-1 mb-3 text-sm">{{ $manga->alternative_titles }}</span>
            <x-manga.genres :genres="$manga->genres" />


            <p class="text-on-surface-variant mt-3">{!! \Illuminate\Support\Str::markdown($manga->description ?? '') !!}</p>

            <div class="flex gap-3 mt-3">
                <div class="flex items-center justify-center gap-1">
                    <x-fas-eye class="text-on-surface-variant/60 h-4 w-4" />
                    <span class="text-sm font-bold">{{ $manga->views->count() }}</span>
                </div>
                <div class="flex items-center justify-center gap-1">
                    <x-fas-bookmark class="text-on-surface-variant/60 h-4 w-4" />
                    <span class="text-sm font-bold">{{ $manga->getTotalFavorites() }}</span>
                </div>
            </div>
            <x-ads.main identifier="below-information-manga" />
            <div class="flex gap-3 mt-4">
                <button id="showChapters" class="tab-active px-3 py-3">{{ __('Chapters') . " ({$chapters->count()})" }}</button>
                <button id="showInfo" class="px-3 py-3">{{ __('Comments') }} ({{$manga->comments->count()}})</button>
            </div>
            <hr class="h-px bg-outline-variant/30 border-0" />

            <div class="block lg:flex lg:gap-5 mt-6">
                <x-manga.chapters :chapters="$chapters" />
                <div id="comments-list" class="hidden w-full lg:w-3/4">
                    @include('comments.index', [
                    'comments' => $manga->comments,
                    'model' => $manga,
                    'modelType' => 'manga',
                    ])
                </div>
                <x-manga.uploader :user="$manga->user" />
            </div>
        </div>
    </div>
</section>
@endsection

@section('title', settings()->get('seo.mangas.title'))
@section('description', settings()->get('seo.mangas.description'))
@extends('layout')
@section('content')
<form action="{{ route('manga.index') }}" method="GET" class="mb-4">
    <div class="flex mb-2 sm:mb-4">
        <div class="w-full md:w-full mb-4 md:mb-0">
            <label for="title" class="block text-sm font-medium dark:dark:text-white !text-opacity-60 mb-2">{{ __('Manga Title') }}</label>
            <x-form.input id="title" name="title" :value="request('title')" placeholder="{{ __('Search for manga...') }}" />
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-2">
        <div class="w-full flex gap-3">
            <div class="w-full mb-4 md:mb-0">
                <label for="type" class="block text-sm font-medium dark:dark:text-white !text-opacity-60 mb-2">{{ __('Manga Type') }}</label>
                <select id="type" class="input-main-light dark:input-main dark:input-main" name="type" class="form-select mt-1 block w-full">
                    <option value="">{{ __('All Types') }}</option>
                    @php
                    $types = \App\Models\Taxonomy::where('type', 'manga_type')->get();
                    @endphp

                    @foreach($types as $type)
                    <option value="{{$type->slug}}" {{ request('type') === $type->slug ? 'selected' : '' }}>
                        {{ $type->title }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full mb-4 md:mb-0">
                <label for="status" class="block text-sm font-medium dark:dark:text-white !text-opacity-60 mb-2">{{ __('Manga Status') }}</label>
                <select id="status" class="input-main-light dark:input-main" name="status" class="form-select mt-1 block w-full">
                    <option value="">{{ __('All Status') }}</option>
                    @php
                    $statuses = \App\Models\Taxonomy::where('type', 'manga_status')->get();
                    @endphp

                    @foreach($statuses as $status)
                    <option value="{{$status->slug}}" {{ request('status') === $status->slug ? 'selected' : '' }}>
                        {{ $status->title }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-1 w-full md:w-1/2">
            <label class="block text-sm font-medium dark:dark:text-white !text-opacity-60">{{ __('Genres') }}</label>
            <div class="grid grid-cols-2 justify-between px-2 py-0">
                @if ($genres->count() > 0)
                @foreach ($genres as $genre)
                <label class="inline-flex items-center  mt-2">
                    <input type="checkbox" name="genre[]" value="{{ $genre->title }}" {{ in_array($genre->title, (array) request('genre', [])) ? 'checked' : '' }} class="p-3 dark:bg-input border-black/10 rounded-md">
                    <span class="mx-2 text-sm dark:text-white text-opacity-70">{{ $genre->title }}</span>
                </label>
                @endforeach
                @else
                <span class="font-sm dark:dark:text-white !text-opacity-60">{{ __('No data has been found') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-3">
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">{{ __('Search') }}</button>
    </div>
</form>

<h2 class="text-lg font-bold mb-3">{{ __('Mangas List') }}</h2>

@if ($mangas->count() == 0)
<p class="text-sm dark:text-white !text-opacity-60 mt-5">{{ __('No data has been found') }}</p>
@endif

<div class="grid grid-cols-3 gap-[10px] sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xlg:grid-cols-8">
    @foreach ($mangas as $manga)

    <div class="rounded-lg">
        <a href="{{ route('manga.show', $manga->slug) }}">
            <figure class="relative">
                <div class="absolute left-0 bottom-0 h-full w-full bg-gradient-to-b from-transparent to-black/50 rounded-lg hover:opacity-0 transition-all duration-200">
                </div>
                <img class="h-56 sm:h-64 w-full object-cover rounded-lg" src="{{ asset('storage/covers/' . $manga->cover) }}" alt="{{ $manga->title }}">

                <div class="absolute bottom-0 p-4">
                    <p class="text-white text-opacity-60 text-xs leading-[1rem] capitalize">
                        {{ $manga->types()->first()->title ?? '' }}</p>
                    <h2 class="text-sm font-semibold text-white">
                        {{ \Illuminate\Support\Str::limit(strip_tags($manga->title), 25, $end = '...') }}
                    </h2>
                </div>
            </figure>
        </a>

        <span class="block mt-1 pl-3">
            @foreach ($manga->genres->take(5) as $genre)
            <a href="{{ url('/manga?genre=' . $genre->slug) }}" class="inline-block rounded-md text-xs text-gray-500 hover:text-gray-400 transition-all duration-200">
                <span>{{ $genre->title }}</span>
                <span class="mr-1">@if (!$loop->last), @endif</span>
            </a>
            @endforeach

        </span>
    </div>


    @endforeach
</div>
<div class="mt-5 mb-5 flex justify-end">
    {{ $mangas->links('pagination.default') }}
</div>

@endsection

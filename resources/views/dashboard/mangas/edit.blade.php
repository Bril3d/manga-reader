@section('title', __('Edit Manga (:title)', ['title' => $manga->title]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Manga (:title)', ['title' => $manga->title])])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas.update', $manga->id) }}" method="POST" id="form-editor" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.group>
            <x-form.input label="{{ __('Title') }}*" id="title" name="title" value="{{ old('title', $manga->title) }}" required />
            <x-form.input label="{{ __('Slug') }}*" id="slug" name="slug" value="{{ old('slug', $manga->slug) }}" required />
        </x-form.group>

        <select id="input-tags" name="genres[]" multiple placeholder="{{ __('Genres') }}" autocomplete="off">
            @foreach(\App\Models\Taxonomy::where('type', 'genre')->get() as $genre)
            <option value="{{ $genre->title }}" {{ (collect(old('genres'))->contains($genre->title) || $manga->genres->contains('title', $genre->title)) ? 'selected' : '' }}>
                {{ $genre->title }}
            </option>
            @endforeach
        </select>


        <input type="hidden" name="description" id="description" value="{{ old('description', $manga->description) }}">
        <x-form.label title="{{ __('Description') }}" />
        <div id="editor"></div>


        <x-form.group>
            <x-form.input label="{{ __('Author') }}" name="author" value="{{ old('author', $manga->author) }}" />
            <x-form.input label="{{ __('Artist') }}" name="artist" value="{{ old('artist', $manga->artist) }}" />
        </x-form.group>

        <x-form.group>
            <x-form.input label="{{ __('Alternative Titles') }}" name="alternative_titles" value="{{ old('alternative_titles', $manga->alternative_titles) }}" />
            <x-form.input label="{{ __('Released Year') }}" name="releaseDate" value="{{ old('releaseDate', $manga->releaseDate) }}" />
        </x-form.group>

        {{-- <x-form.group>
                <x-form.input label="{{ __('Official Links') }}" name="official_links" value="{{ old('official_links', $manga->official_links) }}" />
        <x-form.input label="{{ __('Track Links') }}" name="track_links" value="{{ old('track_links', $manga->track_links) }}" />
        </x-form.group> --}}

        <div class="relative">
            <x-form.label title="{{ __('Cover') }}" />
            <x-form.input type="file" id="cover" name="cover" />
            <span class="cursor-pointer text-md mt-2" id="show-cover">{{ __('Click here to see current cover') }}</span>
            <div class="hidden bg-input p-3 mt-2 w-fit rounded-md" id="cover-wrapper">
                <img class="max-w-1/3 object-contain h-full" src="/storage/covers/{{ $manga->cover }}" alt="cover" />
            </div>
        </div>

        <x-form.group>
            @php
            $types = \App\Models\Taxonomy::where('type', 'manga_type')->pluck('title', 'id')->toArray();
            $status = \App\Models\Taxonomy::where('type', 'manga_status')->pluck('title', 'id')->toArray();
            @endphp
            <x-form.select label="{{ __('Type') }}" name="type" selected="{{ old('status', $manga->types()->first()->id ?? '') }}" :options="['' => '-'] + $types"></x-form.select>
            <x-form.select label="{{ __('Status') }}" name="status" selected="{{ old('status', $manga->status()->first()->id ?? '') }}" :options="['' => '-'] + $status"></x-form.select>
        </x-form.group>

        @php
        $slider = \App\Models\Slider::where('manga_id', $manga->id)->first();
        $isSlider = $slider ? 1 : 0;
        @endphp

        <x-form.select label="{{ __('Add to slider') }}" name="slider_option" selected="{{ old('slider_option', $isSlider) }}" :options="[0 => __('No'), 1 => __('Yes')]"></x-form.select>
        <x-form.input label="{{ __('Slider Cover') }}" type="file" name="slider_cover" />

        @if($slider)
        <div class="bg-input p-3 mt-2 w-fit rounded-md" id="slider-wrapper">
            <img class="max-w-1/3 object-contain h-full" src="/storage/slider/{{ $slider->image }}" alt="slider" />
        </div>
        @endif

        <x-button.primary>{{ __('Update') }}</x-button.primary>

    </form>

    <script>
        const showCoverBtn = document.querySelector('#show-cover');
        const coverWrapper = document.querySelector('#cover-wrapper');

        showCoverBtn.addEventListener('click', () => {
            coverWrapper.classList.toggle('hidden');
        });

    </script>
</div>
@vite(['resources/js/editor.js', 'resources/js/dashboard/manga.js', 'resources/css/tom-select.css'])
@endsection

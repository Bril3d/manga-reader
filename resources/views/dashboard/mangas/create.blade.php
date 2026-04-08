@section('title', __('Add New Manga'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Manga')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.mangas.store') }}" method="POST" id="form-editor" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf

        <x-form.group>
            <x-form.input id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('Title') }}*" required />
            <x-form.input id="slug" name="slug" value="{{ old('slug') }}" placeholder="{{ __('Slug') }}*" required />
        </x-form.group>

        <select id="input-tags" name="genres[]" multiple placeholder="{{ __('Genres') }}" autocomplete="off">
            @foreach(\App\Models\Taxonomy::where('type', 'genre')->get() as $genre)
            <option value="{{ $genre->title }}" {{ (collect(old('genres'))->contains($genre->title)) ? 'selected' : '' }}>
                {{ $genre->title }}
            </option>
            @endforeach
        </select>


        <input type="hidden" name="description" id="description" value="{{ old('description') }}">
        <x-form.label title="{{ __('Description') }}" />
        <div id="editor"></div>

        <x-form.group>
            <x-form.input name="author" value="{{ old('author') }}" placeholder="{{ __('Author') }}" />
            <x-form.input name="artist" value="{{ old('artist') }}" placeholder="{{ __('Artist') }}" />
        </x-form.group>

        {{-- <x-form.group>
            <x-form.input name="official_links" value="{{ old('official_links') }}" placeholder="{{ __('Official Links') }}" />
        </x-form.group> --}}

        {{-- <x-form.input name="track_links" value="{{ old('track_links') }}" placeholder="{{ __('Track Links') }}" /> --}}
        <x-form.group>
            <x-form.input name="alternative_titles" value="{{ old('alternative_titles') }}" placeholder="{{ __('Alternative Titles') }}" />
            <x-form.input name="releaseDate" value="{{ old('releaseDate') }}" placeholder="{{ __('Released Year') }}" />
        </x-form.group>

        <x-form.input label="{{ __('Cover') }}" type="file" id="cover" name="cover" />

        <x-form.group>
            <x-form.select label="{{ __('Type') }}" name="type" selected="{{ old('type') }}" :options="\App\Models\Taxonomy::where('type', 'manga_type')->pluck('title', 'id')->toArray()"></x-form.select>
            <x-form.select label="{{ __('Status') }}" name="status" selected="{{ old('status') }}" :options="\App\Models\Taxonomy::where('type', 'manga_status')->pluck('title', 'id')->toArray()"></x-form.select>
        </x-form.group>

        <x-form.select label="{{ __('Add to slider') }}" name="slider_option" selected="{{ old('slider_option') }}" :options="[0 => __('No'), 1 => __('Yes')]"></x-form.select>
        <x-form.input label="{{ __('Slider Cover') }}" type="file" name="slider_cover" />
        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>

@vite(['resources/js/editor.js', 'resources/js/dashboard/manga.js', 'resources/css/tom-select.css'])

@endsection

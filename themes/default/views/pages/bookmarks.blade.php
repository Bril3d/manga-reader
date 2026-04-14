@section('title', __('Bookmarks'))
@extends('layout')
@section('content')
<h2 class="text-lg font-bold mb-3">{{ __('Bookmarks') }} - {{ auth()->user()->username }}</h2>
@if ($mangas->count() == 0)
<p class="text-sm text-on-surface-variant/60 mt-5">
    {{ __('No bookmarks found! try to add one and try again.') }}</p>
@endif
<div class="grid grid-cols-3 gap-[10px] sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xlg:grid-cols-8">
    @foreach ($mangas as $manga)
    <x-projects.manga :slug="$manga->slug" :title="$manga->title" :type="$manga->type" :cover="$manga->cover" :genres="$manga->genres" />
    @endforeach
</div>
<div class="mt-5 mb-5 flex justify-end">
    {{ $mangas->links('pagination.default') }}
</div>
@endsection

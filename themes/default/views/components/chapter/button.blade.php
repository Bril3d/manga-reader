@props(['chapter', 'slug', 'text'])

@php
$disabledClasses = '!bg-opacity-40 cursor-not-allowed';
$chapter = $chapter ? route('chapter.show', [$slug, $chapter]) : null;
$classes = $chapter ? '' : $disabledClasses;
@endphp

@if ($chapter)
<a href="{{ $chapter }}">
    @endif
    <button class="{{ $classes }}font-semibold px-4 py-3 text-white bg-blue-600 dark:bg-blue-500 rounded-md dark:active:bg-blue-600 active:bg-blue-700 duration-200 transition-all w-full text-sm flex gap-2 justify-center items-center">
        @if ($type === 'prev')
        @if(__('direction') === 'ltr')
        <x-far-hand-point-left class="h-5 w-5" />
        @else
        <x-far-hand-point-right class="h-5 w-5" />
        @endif
        <span>{{ $text }}</span>

        @else
        <span>{{ $text }}</span>
        @if(__('direction') === 'ltr')
        <x-far-hand-point-right class="h-5 w-5" />
        @else
        <x-far-hand-point-left class="h-5 w-5" />
        @endif
        @endif
    </button>
    @if ($chapter)
</a>
@endif

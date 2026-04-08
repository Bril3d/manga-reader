@props(['firstChapter', 'slug', 'id'])

<div class="fixed mx-auto inset-x-0 bottom-3 left-0 w-5/6 flex gap-2 sm:flex-col sm:static sm:w-full z-50" id="buttons">
    @php
    $chapter_link = $firstChapter ? route('chapter.show', [$slug, $firstChapter->chapter_number]) : '';
    $classes = 'flex items-center justify-center text-sm font-bold text-center px-4 py-4 sm:py-3 bg-blue-500 text-white rounded-full sm:rounded-md w-full h-12 w-5/6';
    $classes .= $firstChapter ? ' hover:bg-blue-600 active:scale-95 transition-all duration-150' : '';
    $classes .= !$firstChapter ? ' bg-[#1c2f4c] disabled:cursor-not-allowed' : '';
    @endphp

    <button @if ($firstChapter) onclick="window.location.href='{{ $chapter_link }}'" @endif class="{{ $classes }}" @if (!$firstChapter) disabled @endif>{{ __('Read') }}</button>

    @php
    $isBookmarked =
    auth()->check() &&
    auth()
    ->user()
    ->mangaBookmarks()
    ->where('manga_id', $id)
    ->exists();
    $action = $isBookmarked ? route('bookmarks.delete', $slug) : route('bookmarks.store', $slug);
    $text = $isBookmarked ? __('Remove from Favorites') : __('Add to Favorites');
    @endphp

    <form action="{{ $action }}" method="POST" class="flex w-1/6 sm:w-full">
        @csrf
        @honeypot
        <button type="submit" class="flex gap-1 w-full h-12 sm:h-full text-sm items-center justify-center px-4 py-4 sm:py-2 bg-red-500 text-white rounded-full sm:rounded-md mb-2 hover:bg-red-600 active:scale-95 transition-all duration-150">
            <x-fas-bookmark class="w-4 h-4" />
            <span class="hidden sm:inline-block">{{ $text }}</span>
        </button>
    </form>
</div>

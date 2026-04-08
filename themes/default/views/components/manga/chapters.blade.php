@props(['chapters'])

<div id="chapters-list" class="w-full lg:w-3/4">
    <h2 class="block text-lg font-bold mb-3 leading-[1rem]">{{ __('Chapters List') }}</h2>
    @if ($chapters->count() == 0)
    <p class="dark:text-white !text-opacity-60 text-sm">{{ __('No data has been found') }}</p>
    @endif

    @foreach ($chapters as $chapter)
    <a href="{{ url('/manga/' . $chapter->manga->slug . '/' . $chapter->chapter_number) }}">
        <div class="bg-[hsla(0,0%,55%,.05)] mb-2 p-3 rounded-sm flex justify-between border-[1px] dark:border-black/5">
            <span>{{ __('Chapter') . ' ' . $chapter->chapter_number }}</span>
            <div class="flex justify-between gap-3">
                <span class="text-gray-500">{{ $chapter->created_at ? $chapter->created_at->locale(__('lang'))->diffForHumans() : '-' }}</span>
                <p class="flex items-center gap-1">
                    <span>{{ $chapter->views->count() }}</span>
                    <x-fas-eye class="dark:text-white text-black text-opacity-60 h-4 w-4" />
                </p>
            </div>
        </div>
    </a>
    @endforeach
    <div class="mt-5 flex justify-center">
        {{ $chapters->links('pagination.default') }}
    </div>
</div>

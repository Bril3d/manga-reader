@props(['text' => __('Dropdown'), 'contents' => []])

<div class="relative">
    <button
        class="flex gap-2 items-center justify-between dropdown-btn px-4 py-2 bg-blue-700 text-white font-semibold rounded-md shadow hover:bg-indigo-700">
        <span>{{ $text }}</span>
        <x-fas-chevron-down class="h-4 w-4 inline-block" />
    </button>

    <div class="dropdown-menu hidden absolute left-0 mt-2 w-48 bg-zinc-700 rounded-md shadow-md z-20">
        @foreach ($contents as $content)
            @can($content->permission)
                <a href="{{ $content->link }}"
                    class="block rounded-md font-semibold px-4 py-2 text-white hover:bg-zinc-500 hover:bg-opacity-25">{{ $content->text }}</a>
            @endcan
        @endforeach
    </div>
</div>

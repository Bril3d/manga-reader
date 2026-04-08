@props(['genres'])

<div class="flex gap-1 flex-wrap">
    @foreach ($genres as $genre)
    @if($genre->title)
    <a href="{{ url('/manga?genre=' . $genre->title) }}" class="bg-gray-200 dark:bg-zinc-900 px-3 py-2 inline-block rounded-md text-sm dark:hover:bg-slate-300 dark:hover:bg-opacity-5 hover:bg-gray-100  transition-all duration-200 font-light">{{ $genre->title }}</a>
    @endif
    @endforeach
</div>

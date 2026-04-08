@props(['text', 'info', 'search' => null])


<p class="dark:text-white !text-opacity-50 flex justify-between">
    <span>{{ $text }}</span>
    @if($search)
    <a href="{{ url('manga?'.$search) }}" class="hover:text-blue-500 dark:hover:text-white duration-200 transition-colors">
        @endif
        <span class="capitalize">{{ $info }}</span>
        @if($search)
    </a>
    @endif
</p>

@props(['title', 'has_search' => false, 'search_name' => 'title', 'search_link' => null, 'search_placeholder' => null])


<div class="flex items-center justify-between">
    <h1 class="hidden sm:block text-xl font-semibold dark:text-white w-1/3">{{ $title }}</h1>

    @if($has_search)
    @include('dashboard.search', [
    'name' => $search_name,
    'link' => $search_link,
    'placeholder' => $search_placeholder,
    ])
    @endif
</div>

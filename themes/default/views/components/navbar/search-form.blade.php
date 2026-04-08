@php
    $class = __('direction') === 'rtl' ? 'left-4' : 'right-4';
@endphp

<form method="GET" action="{{ route('manga.index') }}">
    <div class="relative">
        <x-form.input name="title" class="" placeholder="{{ __('Search for manga...') }}" required />
        <button class="absolute {{ $class }} top-3 ">
            <x-fas-search class="w-6 h-6 text-blue-500" />
        </button>
    </div>
</form>

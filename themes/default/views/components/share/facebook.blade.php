@props(['link'])

<a href="{{ $link }}" target="_blank" class="flex items-center justify-center gap-2 bg-blue-600 py-2 px-4 rounded-md text-white">
    <x-fab-facebook class="w-4 h-4 inline-block" />
    <span class="hidden md:inline-block text-sm">{{ __('Share on Facebook')}}</span>
</a>

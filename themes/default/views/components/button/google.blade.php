@props(['class' => null])

<x-button.primary class="w-full dark:bg-transparent border-[1px] border-white/10 shadow dark:hover:bg-transparent flex gap-3 justify-center items-center {{ $class }}">
    <x-fab-google class="w-5 h-5" />
    <span class="font-normal">{{ __('Login with Google') }}</span>
</x-button.primary>
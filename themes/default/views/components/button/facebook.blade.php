@props(['class' => null])

<a href="#">
    <x-button.primary class="w-full dark:bg-blue-700 border-[1px] border-white/10 shadow dark:hover:bg-blue-800/90 flex gap-3 justify-center items-center {{ $class }}">
        <x-fab-facebook class="w-5 h-5" />
        <span class="font-normal">{{ __('Login with Facebook') }}</span>
    </x-button.primary>
</a>
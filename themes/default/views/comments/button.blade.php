@php
$class = __('direction') === 'rtl' ? 'left-4' : 'right-4';
@endphp

<button class="absolute {{ $class }} top-3">
    <x-fas-paper-plane class="w-6 h-6 text-blue-500" />
</button>

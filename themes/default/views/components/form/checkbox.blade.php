@props(['name', 'label', 'class' => null])

<div class="flex gap-2 items-center">
    <input type="checkbox" class="w-5 h-5 rounded-md dark:bg-input dark:border-white/5 {{ $class }}" id="{{ $name }}" name="{{ $name }}" {{ $attributes }} />
    <label for="{{ $name }}" class="">{{ $label }}</label>
</div>

@props(['label' => null, 'name', 'class' => null])

@if ($label)
<div>
    <x-form.label title="{{ $label }}" />
    @endif
    <textarea class="input-main-light dark:input-main w-full {{ $class }}" name="{{ $name }}" {{ $attributes }}>{{ $slot }}</textarea>

    @if ($label)
</div>
@endif

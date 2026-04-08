@props(['id' => null, 'link', 'text' => null, 'icon' => null, 'icon_classes' => null])

<a @if ($id) id="{{ $id }}" @endif href="{{ $link }}"
    {{ $attributes->merge(['class' => 'text-sm p-2 dark:hover:bg-slate-300/5 hover:bg-gray-300/20 hover:rounded-sm flex gap-2 items-center']) }}>
    @if ($icon)
        <x-dynamic-component :component="$icon" class="h-4 w-4 {{ $icon_classes }}" />
    @endif

    @if ($text)
        <span>{{ $text }}</span>
    @endif
</a>

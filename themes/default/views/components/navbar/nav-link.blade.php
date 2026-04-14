@props(['id' => null, 'link', 'text' => null, 'icon' => null, 'icon_classes' => null])

<a @if ($id) id="{{ $id }}" @endif href="{{ $link }}"
    {{ $attributes->merge(['class' => 'text-sm px-4 py-2 font-manrope font-semibold text-on-surface-variant hover:text-neon-purple hover:bg-neon-purple/5 rounded-xl transition-all duration-300 flex gap-2 items-center group']) }}>
    @if ($icon)
        <x-dynamic-component :component="$icon" class="h-4 w-4 transition-transform duration-300 group-hover:scale-110 {{ $icon_classes }}" />
    @endif

    @if ($text)
        <span>{{ $text }}</span>
    @endif

    {{ $slot }}
</a>

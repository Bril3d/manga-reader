@props(['id' => null, 'link', 'text', 'icon' => null])

<a @if($id) id="{{$id}}" @endif href="{{ $link }}" class="flex flex-col items-center justify-center flex-1 py-1 group">
    <div class="relative flex items-center justify-center">
        @if($icon)
        <x-dynamic-component :component="$icon" class="h-5 w-5 text-on-surface-variant group-hover:text-neon-purple transition-all duration-300 group-hover:scale-110" />
        @endif
        <div class="absolute -inset-2 bg-neon-purple/0 group-hover:bg-neon-purple/10 rounded-xl transition-all duration-300 -z-10"></div>
    </div>
    <span class="text-[10px] mt-1 font-manrope font-bold text-on-surface-variant/70 group-hover:text-neon-purple transition-colors">{{ $text }}</span>
</a>
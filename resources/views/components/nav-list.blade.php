@props(['title', 'link' => '#', 'icon' => null, 'active' => false, 'has_menu' => true])

<li class="flex flex-col w-full my-1" id="nav-list">
    <a href="{{ $link }}" class="flex items-center justify-start gap-1 w-full h-12 px-5 rounded-xl hover:bg-neon-purple/10 transition-all duration-300 {{ $active && !$has_menu ?  'bg-neon-purple/10 text-neon-purple shadow-[0_0_15px_rgba(216,185,255,0.1)]' : 'text-on-surface-variant'}}">
        @if($icon)
        <x-dynamic-component :component="$icon" class="w-5 h-5 {{ $active ? 'text-neon-purple' : '' }}" />
        @endif
        <span class="mx-2 text-sm font-semibold tracking-wide uppercase font-manrope lg:block" id="nav-list-title">{{ $title }}</span>
    </a>
    @if($has_menu)
    <div class="{{ $active ? 'flex' : 'hidden' }} text-sm ml-8 mr-4 mt-1 flex-col gap-1 border-l border-outline-variant/30">
        {{ $slot }}
    </div>
    @endif
</li>

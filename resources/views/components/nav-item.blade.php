@props(['route'])

<a href="{{ route($route) }}" class="my-0.5 py-2 px-4 hover:bg-neon-purple/10 text-on-surface-variant hover:text-neon-purple rounded-lg duration-300 transition-all {{ isActiveRoute($route) ? 'text-neon-purple font-semibold bg-neon-purple/5' : '' }}" id="nav-item">
    {{ $slot }}
</a>

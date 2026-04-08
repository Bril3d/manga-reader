@props(['label' => null, 'name', 'type' => 'text', 'class' => null])

<div class="flex flex-col gap-2 w-full">
    @if ($label)
    <label for="{{ $name }}" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/70 font-manrope ml-1">
        {{ $label }}
    </label>
    @endif
    <input type="{{ $type }}" 
           name="{{ $name }}" 
           class="w-full px-5 py-3 bg-surface-container-high/50 backdrop-blur-md border border-outline-variant/30 rounded-xl text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-neon-purple focus:ring-4 focus:ring-neon-purple/10 transition-all duration-300 {{ $class }}" 
           {{ $attributes }} />
</div>

@props(['title', 'value'])

<div class="p-6 glass-card rounded-2xl w-full border border-outline-variant/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
    <div class="flex items-center w-full">
        <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 font-manrope">
            {{ $title }}
        </p>
    </div>
    <div class="flex flex-col justify-start">
        <p class="mt-4 text-4xl font-extrabold text-neon-purple font-epilogue drop-shadow-[0_0_10px_rgba(216,185,255,0.2)]">
            {{ $value }}
        </p>
    </div>
</div>

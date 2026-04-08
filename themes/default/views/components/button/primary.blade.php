@props(['class' => null])

<button type="submit" {{ $attributes->merge(['class' => 'group relative flex items-center justify-center font-bold px-8 py-3 bg-neon-purple text-black rounded-xl hover:scale-105 active:scale-95 shadow-[0_0_20px_rgba(216,185,255,0.3)] hover:shadow-[0_0_30px_rgba(216,185,255,0.5)] transition-all duration-300 overflow-hidden ' . $class]) }}>
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
    <span id="btn-text" class="relative z-10">{{ $slot }}</span>
    <span id="btn-loader" class="hidden absolute right-4 h-5 w-5 animate-spin rounded-full border-4 border-solid border-black border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
        <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
    </span>
</button>

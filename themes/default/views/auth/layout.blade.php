@include('includes.head')
<body class="bg-surface text-on-surface font-manrope h-screen overflow-hidden">
    <main class="flex h-full">
        <!-- Left: Branding & Form -->
        <div class="w-full md:w-[450px] lg:w-[500px] flex flex-col p-8 md:p-12 lg:p-16 border-r border-white/5 bg-surface-container-lowest/30 backdrop-blur-3xl z-10">
            <div class="mb-auto">
                <a href="{{ url('/') }}" class="font-epilogue text-2xl font-black tracking-tighter hover:text-neon-purple transition-colors duration-300">
                    THE <span class="text-neon-purple">NOCTURNE</span>
                </a>
            </div>
            
            <div class="my-auto w-full max-w-sm mx-auto">
                @yield('content')
            </div>

            <div class="mt-auto pt-8 text-xs text-on-surface-variant/30 font-manrope">
                &copy; {{ date('Y') }} THE NEON NOCTURNE. ALL RIGHTS RESERVED.
            </div>
        </div>

        <!-- Right: Cinematic Visual -->
        <div class="hidden md:block flex-1 relative bg-surface-container-lowest overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-surface via-transparent to-transparent z-10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-surface/80 to-transparent z-10"></div>
            <img class="h-full w-full object-cover opacity-40 scale-105 active:scale-110 transition-transform duration-[10s] ease-linear animate-slow-zoom" 
                 src="{{ url('/images/auth.webp') }}" 
                 alt="auth-background">
            
            <div class="absolute bottom-20 left-20 z-20 max-w-lg">
                <h2 class="font-epilogue text-5xl font-black text-white leading-tight tracking-tighter mb-4">
                    ENTER THE <span class="text-neon-purple">VOID.</span>
                </h2>
                <p class="text-on-surface-variant text-lg font-light leading-relaxed">
                    Experience manga as intended. Cinematic, dark, and undistracted.
                </p>
            </div>
        </div>
    </main>
</body>

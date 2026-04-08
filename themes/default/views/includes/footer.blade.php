<footer class="mt-20 border-t border-white/5 py-12 px-6 lg:px-20 bg-surface-container-lowest/50 backdrop-blur-md rounded-t-[3rem]">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
        <div class="flex flex-col items-center md:items-start">
            <a href="{{ url('/') }}" class="font-epilogue text-2xl font-black text-on-surface mb-2 tracking-tighter">
                THE <span class="text-neon-purple">NOCTURNE</span>
            </a>
            <p class="text-on-surface-variant/60 text-xs font-manrope">Your sanctuary for cinematic manga experiences.</p>
        </div>

        <div class="flex gap-6 items-center">
            @if(settings()->get('theme.social.facebook'))
            <a href="{{ settings()->get('theme.social.facebook') }}" target="_blank" class="text-on-surface-variant hover:text-neon-purple transition-colors">
                <x-fab-facebook class="h-5 w-5" />
            </a>
            @endif
            @if(settings()->get('theme.social.instagram'))
            <a href="{{ settings()->get('theme.social.instagram') }}" target="_blank" class="text-on-surface-variant hover:text-neon-purple transition-colors">
                <x-fab-instagram class="h-5 w-5" />
            </a>
            @endif
            @if(settings()->get('theme.social.twitter'))
            <a href="{{ settings()->get('theme.social.twitter') }}" target="_blank" class="text-on-surface-variant hover:text-neon-purple transition-colors">
                <x-fab-twitter class="h-5 w-5" />
            </a>
            @endif
            @if(settings()->get('theme.social.discord'))
            <a href="{{ settings()->get('theme.social.discord') }}" target="_blank" class="text-on-surface-variant hover:text-neon-purple transition-colors">
                <x-fab-discord class="h-5 w-5" />
            </a>
            @endif
        </div>

        <div class="text-xs font-manrope text-on-surface-variant/40">
            &copy; {{ date('Y') }} THE NEON NOCTURNE. ALL RIGHTS RESERVED.
        </div>
    </div>
</footer>

{!! config('custom_html') !!}

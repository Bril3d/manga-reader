@php
$alignmentClass = __('direction') === 'rtl' ? 'left-4 sm:left-8' : 'right-4 sm:right-8';
@endphp

<div id="user-menu" class="hidden animate__animated animate__fadeInUp animate__faster z-[100] fixed bottom-24 sm:top-20 sm:bottom-auto {{ $alignmentClass }} glass backdrop-blur-2xl border border-outline-variant/30 shadow-2xl p-2 rounded-2xl w-64 flex-col gap-1 text-sm font-manrope">
    @guest
    <a href="{{ url('/login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-neon-purple/10 text-on-surface transition-colors">
        <x-fas-sign-in-alt class="h-4 w-4 text-neon-purple" />
        <span class="font-bold">{{ __('Login') }}</span>
    </a>
    <a href="{{ url('/register') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-neon-purple/10 text-on-surface transition-colors">
        <x-fas-user-plus class="h-4 w-4 text-neon-purple" />
        <span class="font-bold">{{ __('Register') }}</span>
    </a>
    @endguest

    @auth
    <div class="px-4 py-3 border-b border-outline-variant/10 mb-1">
        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">{{ __('Account') }}</p>
        <p class="text-sm font-bold text-on-surface truncate">{{ auth()->user()->name }}</p>
    </div>
    <a href="{{ url('/user/settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-neon-purple/10 text-on-surface transition-colors">
        <x-fas-cog class="h-4 w-4 text-on-surface-variant" />
        <span class="font-bold">{{ __('Settings') }}</span>
    </a>
    @can('view_dashboard')
    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-neon-purple/10 text-on-surface transition-colors">
        <x-fas-tachometer-alt class="h-4 w-4 text-neon-purple" />
        <span class="font-bold">{{ __('Dashboard') }}</span>
    </a>
    @endcan
    <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-outline-variant/10 pt-1">
        @csrf
        <a href="{!! route('logout') !!}" id="logout-button" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-500 transition-colors">
            <x-fas-power-off class="h-4 w-4" />
            <span class="font-bold">{{ __('Logout') }}</span>
        </a>
    </form>
    @endauth
</div>

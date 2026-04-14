<header class="sticky top-0 z-50 transition-all duration-300">
    <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
        <div class="glass backdrop-blur-xl border border-outline-variant/30 rounded-2xl shadow-xl shadow-surface/20">
            <div class="container mx-auto px-4 md:px-6">
                <nav class="flex justify-between items-center py-4">
                    <div class="flex gap-8 items-center">
                        <a href="{{ url('/') }}" class="font-epilogue font-black text-neon-purple text-2xl tracking-tighter hover:scale-105 transition-transform">
                            {{ settings()->get('name') }}
                        </a>

                        <div class="hidden lg:flex gap-1 items-center">
                            <x-navbar.nav-link link="{{ route('manga.index') }}" text="{{ __('Mangas') }}" />
                            <x-navbar.nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Favorites') }}" icon="fas-bookmark" icon_classes="text-red-500" />
                            <x-navbar.nav-link link="{{ route('manga.random') }}" text="{{ __('Random') }}" icon="fas-dice" />
                        </div>
                    </div>

                    <div class="flex gap-2 sm:gap-4 items-center">
                        <div class="hidden sm:flex items-center bg-surface-container-high/50 rounded-xl p-1 border border-outline-variant/20 hover:border-neon-purple/30 transition-colors">
                            <x-navbar.nav-link id="search-link" link="#" icon="fas-search" class="!px-3" />
                            <div class="w-px h-4 bg-outline-variant/30 mx-1"></div>
                            <x-navbar.nav-link id="dark-toggle" link="#" class="!px-3">
                                <x-fas-sun class="h-4 w-4 block dark:hidden text-yellow-400" />
                                <x-fas-moon class="h-4 w-4 hidden dark:block text-neon-purple" />
                            </x-navbar.nav-link>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="hidden md:flex gap-1">
                                @foreach(config('app.locales') as $locale)
                                    <a href="{{ route('language.switch', ['locale' => $locale]) }}" 
                                       class="text-[10px] font-bold px-2 py-1 rounded-md border border-outline-variant/20 hover:border-neon-purple/50 text-on-surface-variant transition-colors">
                                        {{ strtoupper($locale) }}
                                    </a>
                                @endforeach
                            </div>
                            
                            <a href="#" id="user-menu-button" class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-tr from-neon-purple to-neon-blue rounded-full blur opacity-0 group-hover:opacity-40 transition duration-500"></div>
                                <img class="relative h-9 w-9 object-cover object-top rounded-full border-2 border-outline-variant group-hover:border-neon-purple transition-all duration-300" 
                                     alt="avatar" 
                                     src="{{ auth()->check() && auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/user/no-image.jpg') }}" />
                            </a>
                        </div>
                    </div>
                </nav>

                <div id="nav-search" class="hidden pb-6 animate__animated animate__fadeInUp animate__faster">
                    <x-navbar.search-form />
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Mobile Floating Bottom Navigation --}}
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[60] w-[90%] max-w-md sm:hidden">
    <div class="glass backdrop-blur-2xl border border-outline-variant/30 rounded-3xl shadow-2xl overflow-hidden px-2 py-1 flex justify-around items-center">
        <x-navbar.phone-nav-link link="{{ url('/') }}" text="{{ __('Home') }}" icon="fas-home" />
        <x-navbar.phone-nav-link link="{{ route('manga.index') }}" text="{{ __('Explore') }}" icon="fas-compass" />
        <x-navbar.phone-nav-link id="search-link-phone" link="#" text="{{ __('Search') }}" icon="fas-search" />
        @auth
        <x-navbar.phone-nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Wishlist') }}" icon="fas-heart" />
        @endauth
        <x-navbar.phone-nav-link id="user-menu-mobile" link="#" text="{{ __('Menu') }}" icon="fas-user" />
    </div>
</div>

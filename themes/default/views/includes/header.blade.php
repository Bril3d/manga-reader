<header class="sticky top-0 z-50 glass backdrop-blur-xl border-b border-white/5 mx-4 sm:mx-6 lg:mx-8 mt-4 rounded-2xl transition-all duration-300">
    <div class="container mx-auto px-4 md:px-6">

    <nav class="flex justify-between py-6">
        <div class="flex gap-3">
            <a href="{{ url('/') }}" class="py-2 font-bold">{{ settings()->get('name') }}</a>

            <div class="hidden sm:flex gap-1 items-center">
                <x-navbar.nav-link link="{{ route('manga.index') }}" text="{{ __('Mangas') }}" />
                <x-navbar.nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Favorites') }}" icon="fas-bookmark" icon_classes="text-red-500" />
                <x-navbar.nav-link link="{{ route('manga.random') }}" text="{{ __('Random') }}" icon="fas-dice" />
                <x-navbar.nav-link id="search-link" link="#" text="{{ __('Search') }}" />
            </div>
        </div>
        <div class="relative flex gap-2 sm:gap-5 items-center">
            <div class="flex gap-1">
                {{-- @foreach(config('app.locales') as $locale)
                <x-navbar.nav-link link="{{ route('language.switch', ['locale' => $locale]) }}" icon="fas-language" text="{{ strtoupper($locale) }}" />
                @endforeach --}}
                <x-navbar.nav-link id="dark-toggle" link="#" icon="fas-sun" aria-label="{{ __('Dark Mode') }}" />
            </div>
            <a href="#" id="user-menu-button" aria-label="usermenu">
                <img class="h-9 w-9 object-cover object-top rounded-full border-[1px] border-solid border-black/10" alt="avatar" src="{{ auth()->check() && auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/user/no-image.jpg') }}" />
            </a>
            <x-navbar.user-menu />
        </div>
    </nav>

    <div id="nav-search" class="hidden mb-8 animate__animated animate__fast">
        <x-navbar.search-form />
    </div>
    </div>
</header>

<div id="phone-nav" class="flex sm:hidden md:hidden lg:hidden p-3 -mt-4 mb-4 bg-gray-500/5 dark:bg-blue-600">
    <div class="flex gap-3 justify-center w-full text-sm">
        <x-navbar.phone-nav-link link="{{ route('manga.index') }}" text="{{ __('Mangas') }}" icon="fas-list" />
        <x-navbar.phone-nav-link link="{{ route('manga.random') }}" text="{{ __('Random') }}" icon="fas-dice" />
        @auth
        <x-navbar.phone-nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Favorites') }}" icon="fas-bookmark" />
        @endauth
        <x-navbar.phone-nav-link id="search-link-phone" link="#" text="{{ __('Search') }}" icon="fas-search" />
    </div>
</div>

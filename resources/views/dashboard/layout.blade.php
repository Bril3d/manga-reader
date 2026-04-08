@include('dashboard.includes.head')

<body class="bg-surface text-on-surface font-manrope flex grow overflow-y-auto antialiased">
    @include('dashboard.includes.side-nav')


    <div class="w-full overflow-y-auto max-h-[100vh] py-3 px-5 md:px-10 bg-surface text-on-surface">
        <div class="border-b border-outline-variant py-5 mb-5 block md:hidden">
            <a href="#" id="toggle-button">
                <x-fas-list-ul class="w-7 h-7 text-neon-purple" />
            </a>
        </div>
        <div class="mb-5">
            <div class="border-b border-outline-variant pb-5">
                <h3 class="text-4xl leading-tight font-epilogue font-extrabold text-on-surface md:mt-10">{{ __('Dashboard') }}</h3>
                <p class="mt-2 max-w-4xl text-lg font-medium text-on-surface-variant">{{ __('Welcome to your dashboard, here you can manage your mangas, chapters, comments, categories and members.') }}</p>
            </div>
        </div>
        @yield('content')
        @include('dashboard.includes.footer')
    </div>
</body>

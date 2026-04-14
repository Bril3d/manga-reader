@include('includes.head')

<body class="bg-surface text-on-surface font-manrope selection:bg-neon-purple/30 flex flex-col min-h-screen">
    @include('includes.header')
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 sm:pb-8 animate-fadeIn">
        @yield('content')
    </main>
    @include('includes.footer')
    <x-navbar.user-menu />
</body>
</html>

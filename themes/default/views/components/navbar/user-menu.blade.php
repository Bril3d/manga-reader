@php
$class = __('direction') === 'rtl' ? '-left-1' : '-right-1';
@endphp

<div id="user-menu" class="border-[1px] dark:border-none hidden animate__animated animate__fadeIn animate__faster z-30 top-10 {{ $class }} bg-gray-50 shadow dark:bg-dark-secondary p-4 rounded-md w-60 flex-col gap-2 text-sm">
    @guest
    <a href="{{ url('/register') }}">{{ __('Register') }}</a>
    <a href="{{ url('/login') }}">{{ __('Login') }}</a>
    @endguest

    @auth
    <a href="{{ url('/user/settings') }}">{{ __('User Setting') }}</a>
    @can('view_dashboard')
    <a href="{{ url('/dashboard') }}">{{ __('Admin Dashboard') }}</a>
    @endcan
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{!! route('logout') !!}" id="logout-button">{{ __('Logout') }}</a>
    </form>
    @endauth
</div>

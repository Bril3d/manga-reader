@section('title', __('Login'))
@extends('auth.layout')
@section('content')
@include('auth.heading', ['text' => __('Go Back'), 'title' => __('Login')])
<div class="space-y-6">
    <x-alert.success :status="session('status')" />
    <x-alert.error :errors="$errors" />

    <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <x-form.input type="email" name="email" placeholder="{{ __('Email') }}" :value="old('email')" required />
        <div class="space-y-2">
            <x-form.input type="password" name="password" placeholder="{{ __('Password') }}" required />
            <div class="flex justify-end">
                <a class="text-on-surface-variant/60 hover:text-neon-purple transition-colors text-xs" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            </div>
        </div>
        <x-form.checkbox name="remember" label="{{ __('Remember me') }}" class="w-5" />
        <x-button.primary class="w-full py-4">{{ __('Login') }}</x-button.primary>
    </form>

    <div class="pt-4 border-t border-white/5 text-center">
        <p class="text-sm text-on-surface-variant">
            {{ __('Don\'t have an account?') }}
            <a class="text-neon-cyan hover:text-neon-cyan/80 font-bold ml-1 transition-colors" href="{{ url('/register') }}">
                {{ __('Register here') }}
            </a>
        </p>
    </div>
</div>
@endsection

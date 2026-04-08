@section('title', __('Register'))
@extends('auth.layout')
@section('content')
@include('auth.heading', ['text' => __('Go Back'), 'title' => __('Register')])
<div class="space-y-6">
    <x-alert.error :errors="$errors" />
    <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <x-form.input type="text" name="username" placeholder="{{ __('Username') }}" :value="old('username')" required />
        <x-form.input type="email" name="email" placeholder="{{ __('Email Address') }}" :value="old('email')" required />
        <x-form.input type="password" name="password" placeholder="{{ __('Password') }}" required />
        <x-form.input type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required />
        <x-button.primary class="w-full py-4 mt-2">{{ __('Create Account') }}</x-button.primary>
    </form>

    <div class="pt-4 border-t border-white/5 text-center">
        <p class="text-sm text-on-surface-variant">
            {{ __('Already have an account?') }}
            <a class="text-neon-cyan hover:text-neon-cyan/80 font-bold ml-1 transition-colors" href="{{ route('login') }}">
                {{ __('Login here') }}
            </a>
        </p>
    </div>
</div>
@endsection

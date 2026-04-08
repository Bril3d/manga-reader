@section('title', __('Reset Password'))
@extends('auth.layout')
@section('content')
@include('auth.heading', ['text' => __('Go Back'), 'title' => __('Reset Password')])
<div>
    <x-alert.success :status="session('status')" />
    <x-alert.error :errors="$errors" />

    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-3">
        @csrf
        <input type="hidden" name="token" value="{{ $request->token }}">
        <x-form.input type="email" name="email" placeholder="{{ __('Email') }}" :value="old('email', $request->email)" :required="true" />
        <x-form.input type="password" name="password" placeholder="{{ __('Password') }}" :required="true" />
        <x-form.input type="password" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}" :required="true" />
        <x-button.primary>{{ __('Reset Password') }}</x-button.primary>
    </form>
</div>
@endsection

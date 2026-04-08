@section('title', __('Reset Password'))
@extends('auth.layout')
@section('content')
@include('auth.heading', ['text' => __('Go Back'), 'title' => __('Reset Password')])
<div>

    <x-alert.success :status="session('status')" />
    <x-alert.error :errors="$errors" />

    <form action="{{ route('password.email') }}" method="POST" class="flex flex-col gap-3">
        @csrf
        <x-form.input type="email" name="email" placeholder="{{ __('Email') }}" :value="old('email')" :required="true" />
        <x-button.primary>{{ __('Send Password Reset Link') }}</x-button.primary>
    </form>
</div>
@endsection

@section('title', __('Email verification'))
@extends('auth.layout')
@section('content')
@include('auth.heading', ['text' => __('Go Back'), 'title' => __('Email verification')])
<div class="-mt-4">
    <x-alert.success :status="session('status')" />

    <form action="{{ route('verification.send') }}" method="POST" class="flex flex-col gap-3">
        @csrf
        <x-button.primary>{{ __('Send another request') }}</x-button.primary>
    </form>
</div>
@endsection

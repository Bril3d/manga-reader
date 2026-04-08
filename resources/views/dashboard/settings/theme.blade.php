@section('title', __('Edit Theme Settings'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Theme Settings')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_theme') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')


        @php
        $themes = [];
        foreach (glob(base_path('themes') . '/*', GLOB_ONLYDIR) as $dir) {
        $themes[basename($dir)] = basename($dir);
        }
        @endphp

        <x-form.select label="{{ __('Default Theme') }}" name="theme_active" selected="{{ old('theme_active', settings()->get('theme.active')) }}" :options="$themes"></x-form.select>

        <x-form.select label="{{ __('Default Mode') }}" name="theme_mode" selected="{{ old('theme_mode', settings()->get('theme.mode')) }}" :options="
        [
            'dark' => __('Dark'),
            'light' => __('Light')
        ]"></x-form.select>

        <x-form.select label="{{ __('Theme Slider') }}" name="theme_slider" selected="{{ old('theme_slider', settings()->get('theme.slider')) }}" :options="
        [
            'enabled' => __('Enabled'),
            'disabled' => __('Disabled')
        ]"></x-form.select>

        <x-form.input label="{{__('Facebook link')}}" name="facebook" :value="old('facebook', settings()->get('theme.social.facebook'))" />
        <x-form.input label="{{__('Instagram link')}}" name="instagram" :value="old('instagram', settings()->get('theme.social.instagram'))" />
        <x-form.input label="{{__('Twitter link')}}" name="twitter" :value="old('facebook', settings()->get('theme.social.twitter'))" />
        <x-form.input label="{{__('Discord link')}}" name="discord" :value="old('discord', settings()->get('theme.social.discord'))" />
        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

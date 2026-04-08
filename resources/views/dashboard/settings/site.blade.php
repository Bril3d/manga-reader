@section('title', __('Edit Site Settings'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Site Settings')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_site') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')
        <x-form.input label="{{__('Site Title')}}" name="name" :value="old('name', settings()->get('name'))" />
        <x-form.input label="{{__('Site URL')}}" name="url" :value="old('url', settings()->get('url'))" />

        <x-form.group>
            <x-form.input label="{{__('Site Description')}}" name="description" :value="old('description', settings()->get('description'))" />
            <x-form.input label="{{__('Site Keywords')}}" name="keywords" :value="old('keywords', settings()->get('keywords'))" />
        </x-form.group>

        <x-form.group>
            <x-form.input label="{{__('Site Logo')}}" type="file" name="logo" />
            <x-form.input label="{{__('Site Favicon')}}" type="file" name="favicon" />
        </x-form.group>

        <x-form.select label="{{ __('Website Main Language') }}" name="locale" selected="{{ old('locale', settings()->get('locale')) }}" :options="['en' => __('English'), 'ar' => __('Arabic')]"></x-form.select>

        <x-form.textarea label="{{__('Additional HTML')}}" name="custom_html">
            {{ old('custom_html', settings()->get('custom_html')) }}
        </x-form.textarea>

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

@section('title', __('Add New Ad'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Add New Ad')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.ads.store') }}" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
        @csrf
        <x-form.group>
            <x-form.input id="title" name="name" :value="old('name')" placeholder="{{ __('Ad Name') }}" />
            <x-form.input id="slug" name="identifier" :value="old('identifier')" placeholder="{{ __('Ad Identifier') }}" />
        </x-form.group>
        <x-form.select id="ad-type" label="{{ __('Type') }}" name="type" selected="{{ old('type') }}" :options="['banner' => __('Banner'), 'script' => __('Script')]"></x-form.select>

        <div id="ad-banner" class="flex flex-col gap-4">
            <x-form.input label="{{__('Image')}}" type="file" name="image" />
            <x-form.input name="link" :value="old('link')" placeholder="{{ __('Ad Link') }}" />
        </div>


        <div id="ad-script" class="hidden">
            <x-form.textarea name="script" label="{{ __('Ad Script') }}">{{ old('script') }}</x-form.textarea>
        </div>

        <x-form.select label="{{ __('Status') }}" name="is_active" selected="{{ old('is_active') }}" :options="['1' => __('Active'), '0' => __('Disabled')]"></x-form.select>

        <x-button.primary>{{ __('Submit') }}</x-button.primary>
    </form>
</div>
@endsection

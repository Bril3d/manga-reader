@section('title', __('Edit Uploading Settings'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Uploading Settings')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_upload') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.select label="{{ __('Preferred Images Extension. deafult: webp') }}" name="extension" selected="{{ old('extension', settings()->get('extension')) }}" :options="
        [
            'webp' => __('webp - Recommended'),
            'jpg' => __('jpg - Not Recommended'),
            'jpeg' => __('jpeg - Not Recommended'),
            'png' => __('png - Not Recommended'),
            'same' => __('Same as uploaded - Not Recommended')
        ]"></x-form.select>

        <x-form.input label="{{__('Images Quality 1 - 100 (70 - 80 is the best)')}}" type="number" name="quality" :value="old('quality', settings()->get('quality'))" />
        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

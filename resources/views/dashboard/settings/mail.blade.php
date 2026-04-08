@section('title', __('Edit Mail Settings'))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Mail Settings')])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_mail') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.select label="{{ __('Mail Mailer') }}" name="driver" selected="{{ old('driver', settings()->get('mail.driver')) }}" :options="['sendmail' => __('Sendmail'), 'smtp' => __('SMTP')]"></x-form.select>
        <x-form.input label="{{__('Mail Host')}}" name="host" :value="old('host', settings()->get('mail.host'))" />
        <x-form.input label="{{__('Mail Port')}}" name="port" :value="old('port', settings()->get('mail.port'))" />
        <x-form.input label="{{__('Mail Username')}}" name="username" :value="old('username', settings()->get('mail.username'))" />
        <x-form.input label="{{__('Mail Password')}}" name="password" :value="old('password', settings()->get('mail.password'))" />
        <x-form.select label="{{ __('Mail Encryption') }}" name="encryption" selected="{{ old('encryption', settings()->get('mail.encryption')) }}" :options="['ssl' => __('ssl'), 'tls' => __('tls')]"></x-form.select>
        <x-form.input label="{{__('Mail From')}}" name="address" :value="old('address', settings()->get('mail.address'))" />

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

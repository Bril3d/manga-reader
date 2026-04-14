@section('title', __('User Setting'))
@extends('layout')
@section('content')
<div id="update-user" class="flex flex-col items-center justify-center">
    <div class="md:w-2/3 flex flex-col">
        <x-alert.info>{{ __('We take privacy issues seriously. You can be sure that your personal data is securely protected.') }}</x-alert.info>
        <x-alert.success :status="session('status')" />
        <x-alert.error :errors="$errors->updateProfileInformation" />

        <div class="flex wrap gap-10 mt-10">
            <div class="hidden lg:block lg:w-2/5">
                <h2 class="text-lg font-bold my-3">{{ __('Personal Information') }} - ({{ auth()->user()->username }})</h2>
                <p class="text-on-surface-variant/60 text-sm">{{ __('Update your username, email or your description. Remember if you changed the email you will need to reactivate the new email.') }}</p>
            </div>
            <div class="w-full lg:w-3/5">
                <form action="{{ route('user-profile-information.update') }}" method="POST" class="flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <x-form.group>
                        <x-form.input label="{{ __('Username') }}" type="text" name="username" :value="auth()->user()->username" />
                        <x-form.input label="{{ __('Email') }}" type="email" name="email" :value="auth()->user()->email" />
                    </x-form.group>

                    <x-form.input label="{{ __('Description') }}" type="text" name="description" :value="auth()->user()->description" />

                    @if (!auth()->user()->hasVerifiedEmail())
                    <span class="text-red-500">{{ __("This email isn't verified, if you didn't recieve the verification message,") }} <a class="text-blue-500 hover:text-blue-700 duration-200 transition-all" href="{{ route('verification.notice') }}">{{ __('click here') }}</a> {{ __('to resend it!') }}</span>
                    @endif
                    <x-button.primary>{{ __('Update') }}</x-button.primary>
                </form>
            </div>
        </div>
        <hr class="mt-10 mb-10 border-outline-variant/30">

        <div class="flex wrap gap-10">
            <div class="hidden lg:block lg:w-2/5">
                <h2 class="text-lg font-bold my-3">{{ __('Security') }}</h2>
                <p class="text-on-surface-variant/60 text-sm">{{ __('Update your security information from this section!') }}</p>
            </div>

            <div id="update-password" class="w-full lg:w-3/5">
                <x-alert.error :errors="$errors->updatePassword" />
                <form action="{{ route('user-password.update') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    @method('PUT')
                    <x-form.input label="{{__('Current Password')}}" type="password" name="current_password" />
                    <x-form.input label="{{__('Password')}}" type="password" name="password" />
                    <x-form.input label="{{__('Password Confirmation')}}" type="password" name="password_confirmation" />
                    <x-button.primary>{{ __('Update') }}</x-button.primary>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

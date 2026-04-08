@props(['user'])

<div class="hidden lg:block lg:w-1/4">
    <p class="block text-lg font-bold mb-3 leading-[1rem]">{{ __('Uploader') }}</p>
    <div class="flex gap-3">
        <div class="relative ">
            <img class="w-14 h-14 object-cover rounded-md" alt="{{ $user->username }}"
                src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('images/user/no-image.jpg') }}" />
            <div
                class="absolute w-full h-full bottom-0 left-0 rounded-md bg-black bg-opacity-40 hover:bg-opacity-0 transition-all duration-200">
            </div>
        </div>
        <div>
            <p class="font-bold">{{ $user->username }}</p>
            <p class="dark:text-white text-black text-opacity-60 text-sm">{{ $user->description ?? '-' }}</p>
        </div>
    </div>
</div>

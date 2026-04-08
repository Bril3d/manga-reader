@include('includes.head')
@section('title', __('Error 403'))
<main class="h-[100vh] dark:bg-dark-primary dark:text-white">
    <section class="container mx-auto px-3 sm:px-0 md:px-0 flex flex-col items-center justify-center h-full">
        <h2 class="text-3xl font-bold mb-3 text-center">{{ __('Error 403') }}</h2>
        <div class="rounded-md flex flex-col gap-10 p-10 pt-2 items-center text-center">
            <div>
                <p>{{ __('You are trying to make an Unauthorized action!') }}</p>
                <p>{{ __('You can go back to homepage by clicking the next button!') }}</p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-3 duration-200 transition-all shadow-black/50 shadow-md dark:shadow-none">
                    <x-fas-arrow-left-long class="h-4 w-4" />
                    <span>{{ __('Go back to homepage') }}</span>
                </a>
            </div>
    </section>
</main>

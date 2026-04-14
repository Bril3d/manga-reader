@section('title', __('Homepage'))
@extends('layout')
@section('content')
@if (!request()->has('page') || request('page') == 1)

@if(settings()->get('theme.slider') == 'enabled' && $sliders->count() > 0)
<section class="mb-12 -mt-8 relative h-[60vh] lg:h-[75vh] w-full overflow-hidden rounded-3xl group">
    <swiper-container id="home-slider" init="false" navigation="true" pagination="true" effect="fade" class="h-full w-full">
        @foreach ($sliders as $manga)
        <swiper-slide class="relative h-full w-full cursor-pointer" onclick="location.href = '{{ route('manga.show', $manga->slug) }}';">
            <div class="absolute inset-0 bg-gradient-to-r from-surface via-surface/40 to-transparent z-10"></div>
            <img class="h-full w-full object-cover lazyload scale-105 group-hover:scale-100 transition-transform duration-1000" 
                 data-src="{{ asset('storage/slider/' . $manga->slider()->first()->image) }}" 
                 alt="{{ $manga->title }}">
            
            <div class="absolute inset-0 z-20 flex flex-col justify-center px-6 lg:px-20 max-w-4xl">
                <span class="text-neon-purple font-manrope font-bold tracking-widest uppercase text-xs mb-4 animate-fadeIn">Featured Selection</span>
                <h1 class="font-epilogue text-4xl lg:text-7xl font-black text-on-surface leading-none mb-6 drop-shadow-2xl">
                    {{ \Illuminate\Support\Str::limit(strip_tags($manga->title), 40) }}
                </h1>
                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($manga->genres->take(3) as $genre)
                        <span class="px-4 py-1.5 rounded-full border border-outline-variant bg-white/5 backdrop-blur-md text-xs font-semibold text-on-surface-variant">
                            {{ $genre->title }}
                        </span>
                    @endforeach
                </div>
                <div class="flex gap-4">
                    <button class="btn-neon font-epilogue">Read Now</button>
                    <button class="px-8 py-3 rounded-xl border border-outline-variant bg-white/5 backdrop-blur-md font-epilogue font-bold text-on-surface hover:bg-white/10 transition-colors">Details</button>
                </div>
            </div>
        </swiper-slide>
        @endforeach
    </swiper-container>
</section>
@endif

@if($popular->count() > 0)
<section class="mb-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-epilogue text-3xl font-bold text-on-surface mb-2">Popular Today</h2>
            <p class="text-on-surface-variant text-sm font-manrope">Most read titles in the last 24 hours</p>
        </div>
        <a href="#" class="text-neon-purple font-manrope font-bold text-sm hover:underline">View All</a>
    </div>

    <swiper-container id="popular-mangas" init="false" slides-per-view="auto" space-between="24" class="pb-8">
        @foreach ($popular as $manga)
        <swiper-slide class="w-48 sm:w-56 group">
            <a href="{{ url('/manga/' . $manga->slug) }}" class="block">
                <div class="relative aspect-[2/3] rounded-2xl overflow-hidden mb-4 shadow-2xl transition-all duration-500 group-hover:scale-[1.02] group-hover:shadow-neon-purple/20">
                    <img class="h-full w-full object-cover lazyload transition-all duration-500 group-hover:brightness-110" 
                         data-src="{{ str_starts_with($manga->cover, 'http') ? $manga->cover : (str_contains($manga->cover, '/') ? asset('storage/' . $manga->cover) : asset('storage/covers/' . $manga->cover)) }}" 
                         alt="{{ $manga->title }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-surface via-transparent to-transparent opacity-60"></div>
                </div>
                <div class="px-1">
                    <span class="text-[10px] font-manrope font-bold tracking-widest uppercase text-on-surface-variant/60">{{ __($manga->type) }}</span>
                    <h3 class="font-epilogue text-md font-bold text-on-surface leading-tight group-hover:text-neon-purple transition-colors truncate">
                        {{ $manga->title }}
                    </h3>
                </div>
            </a>
        </swiper-slide>
        @endforeach
    </swiper-container>
</section>
@endif


@if($latest->count() > 0)
<x-ads.main identifier="above-latest-home" />
<section>
    <h2 class="text-lg font-bold my-3">{{ __('Recently Added') }}</h2>
    <swiper-container class="!hidden" id="latest-mangas" init="false">
        @foreach ($latest as $manga)
        <swiper-slide class="rounded-lg">
            <a href="{{ url('/manga/' . $manga->slug) }}">
                <figure class="relative">
                    <div class="absolute left-0 bottom-0 h-full w-full bg-gradient-to-b from-transparent to-black/50 rounded-lg hover:opacity-50 transition-all duration-200">
                    </div>
                    <img class="h-56 sm:h-64 w-full object-cover rounded-lg lazyload shadow-md shadow-black/20 dark:shadow-none" data-src="{{ str_starts_with($manga->cover, 'http') ? $manga->cover : (str_contains($manga->cover, '/') ? asset('storage/' . $manga->cover) : asset('storage/covers/' . $manga->cover)) }}" alt="{{ $manga->title }}">
                    <div class="absolute bottom-0 p-4">
                        <p class="text-white text-opacity-60 text-xs leading-[1rem] capitalize">{{ __($manga->type) }}</p>
                        <h2 class="text-sm font-semibold text-white">{{ \Illuminate\Support\Str::limit(strip_tags($manga->title), 25, $end = '...') }}</h2>
                    </div>
                </figure>
            </a>
        </swiper-slide>
        @endforeach
    </swiper-container>
</section>
@else
<x-alert.info>
    {{ __('There is no mangas yet.') }}
</x-alert.info>
@endif
@endif

@if($chapters->count() > 0)
<section class="my-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-epilogue text-3xl font-bold text-on-surface mb-2">Recent Chapters</h2>
            <p class="text-on-surface-variant text-sm font-manrope">Fresh updates from your favorite scanlations</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($chapters as $manga)
        <div class="bg-surface-container-low rounded-3xl p-4 flex gap-4 hover:bg-surface-container-high transition-all duration-300 group">
            <a href="{{ url('/manga/' . $manga->slug) }}" class="shrink-0">
                <div class="relative w-24 aspect-[2/3] rounded-xl overflow-hidden shadow-lg">
                    <img class="h-full w-full object-cover lazyload" 
                         data-src="{{ str_starts_with($manga->cover, 'http') ? $manga->cover : (str_contains($manga->cover, '/') ? asset('storage/' . $manga->cover) : asset('storage/covers/' . $manga->cover)) }}" 
                         alt="{{ $manga->title }}">
                </div>
            </a>
            <div class="flex flex-col justify-center flex-grow min-w-0">
                <span class="text-[10px] font-manrope font-bold text-neon-purple/70 uppercase tracking-tighter mb-1">{{ __($manga->type) }}</span>
                <h3 class="font-epilogue text-sm font-bold text-on-surface mb-3 truncate group-hover:text-neon-purple transition-colors">
                    {{ $manga->title }}
                </h3>
                <div class="flex flex-col gap-2">
                    @foreach ($manga->chapters->sortByDesc('chapter_number')->take(2) as $chapter)
                    <a href="{{ url('/manga/' . $manga->slug . '/' . $chapter->chapter_number) }}" 
                       class="flex justify-between items-center bg-surface-container-highest/50 hover:bg-neon-purple/10 px-3 py-2 rounded-xl transition-all duration-200">
                        <span class="text-xs font-manrope font-bold text-on-surface">Ch. {{ $chapter->chapter_number }}</span>
                        <span class="text-[10px] text-on-surface-variant/60">{{ $chapter->created_at ? $chapter->created_at->diffForHumans() : '-' }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-12 flex justify-center">
        {{ $chapters->links('pagination.default') }}
    </div>
</section>
@endif
@endsection

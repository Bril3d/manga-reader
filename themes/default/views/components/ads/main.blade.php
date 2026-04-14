@props(['identifier'])
@php
$ad = \App\Models\Ad::where('identifier', $identifier)->where('is_active', true)->first();
@endphp

@if($ad)
<div class="my-3 flex justify-center">
    @if($ad->type == 'script')
    {!! $ad->script !!}
    @elseif($ad->type == 'banner')
    <a href="{{ route('ads.redirect', $ad->id) }}">
        <img src="{{ asset('storage/'. $ad->image) }}" alt="{{ __('Ad') }}" class="w-full max-h-52" />
    </a>
    @endif
</div>
@endif

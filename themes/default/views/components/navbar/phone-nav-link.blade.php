@props(['id' => null, 'link', 'text', 'icon' => null])

<a @if($id) id="{{$id}}" @endif href="{{ $link }}" class="flex gap-2 items-center">
    @if($icon)
    <x-dynamic-component :component="$icon" class="h-4 w-4" />
    @endif
    <span>{{ $text }}</span>
</a>
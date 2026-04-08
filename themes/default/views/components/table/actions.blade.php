@props(['edit' => null, 'delete' => null, 'restore' => null])

@if($restore)
<span class="after:content-['-'] after:mx-1">
    <a href="{{ $restore }}" class="table-action">{{ __('Restore') }}</a>
</span>
@else
<span class="after:content-['-'] after:mx-1">
    <a href="{{ $edit }}" class="table-action">{{ __('Edit') }}</a>
</span>
@endif

<a class="table-action" href="{{ $delete }}" onclick="return confirm('Are you sure?')">{{ __('Delete') }}</a>
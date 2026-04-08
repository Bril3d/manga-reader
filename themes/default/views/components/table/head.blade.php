@props(['headings'])

@php
$class = __('direction') === 'rtl' ? 'text-right' : 'text-left';
$class_dir = __('direction') === 'rtl' ? 'pr-6' : 'pl-6';
@endphp

<thead class="bg-surface-container-highest/50 backdrop-blur-md border-b border-outline-variant/20">
    <tr>
        @foreach ($headings as $heading)
        <th scope="col" class="py-4 {{ $class }} text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 font-manrope {{ $class_dir }}">
            {{ $heading }}
        </th>
        @endforeach
        <th class="py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 font-manrope {{ $class_dir }}">
            <span class="sr-only">Edit</span>
        </th>
    </tr>
</thead>

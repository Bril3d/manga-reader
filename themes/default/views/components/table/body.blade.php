@props(['contents', 'headings'])

@php
$class_dir = __('direction') === 'rtl' ? 'pr-6' : 'pl-6';
@endphp

<tbody class="divide-y divide-outline-variant/10 bg-surface-container-low/30">
    @if (count($contents) == 0)
    <tr>
        <td colspan="{{ $headings + 1 }}" class="p-8 text-sm text-on-surface-variant/60 text-center font-manrope">
            <div class="flex flex-col items-center gap-2">
                <svg class="w-8 h-8 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <span>{{ __('No data has been found') }}</span>
            </div>
        </td>
    </tr>
    @endif

    @foreach ($contents as $key => $content)
    <tr class="hover:bg-on-surface/[0.03] transition-colors duration-200 group">
        @foreach ($content as $key => $column)
        @if ($key == 'edit' || $key == 'delete' || $key == 'restore') @continue @endif
        <td class="{{ $class_dir }} py-4 text-sm text-on-surface/80 group-hover:text-on-surface transition-colors">
            {{ $column }}
        </td>
        @endforeach

        @php
        $content['restore'] = $content['restore'] ?? null;
        $content['edit'] = $content['edit'] ?? null;
        $content['delete'] = $content['delete'] ?? null;
        @endphp

        <td class="px-6 py-4 text-right">
            @if($content['restore'])
                <x-table.actions :restore="$content['restore']" :delete="$content['delete']" />
            @else
                @if($content['edit'] && $content['delete'])
                    <x-table.actions :edit="$content['edit']" :delete="$content['delete']" />
                @endif
            @endif
        </td>
    </tr>
    @endforeach
</tbody>

@props(['status' => null])

@if ($status)
    <div class="bg-green-600 rounded-md p-4 mb-3">
        <p class="text-sm">{{ $status }}</p>
    </div>
@endif

@props(['errors'])

@if($errors->any())
<div class="bg-red-500 rounded-md p-4 mb-3">
    @foreach ($errors->all() as $error)
    <p class="text-sm">{{ $error }}</p>
    @endforeach
</div>
@endif
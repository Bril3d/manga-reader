@section('title', $page->title)
@extends('layout')
@section('content')
<h2 class="text-lg font-bold mb-3">{{ $page->title }}</h2>
<div class="bg-gray-500 bg-opacity-10 rounded-md p-4">
    {!! \Illuminate\Support\Str::markdown($page->content ?? '') !!}
</div>
@endsection

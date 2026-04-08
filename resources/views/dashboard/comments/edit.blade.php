@section('title', __('Edit Comment (#:id)', ['id' => $comment->id]))
@extends('dashboard.layout')
@section('content')

<div class="flex flex-col gap-5">
    @include('dashboard.header', ['title' => __('Edit Comment (#:id)', ['id' => $comment->id])])

    <x-alert.error :errors="$errors" />

    <form action="{{ route('dashboard.comments.update', $comment->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <x-form.label title="{{ __('Content') }}" />
        <x-form.input name="content" :value="old('content', $comment->content)" placeholder="{{ __('Comment content...') }}" />

        <x-button.primary>{{ __('Update') }}</x-button.primary>
    </form>
</div>
@endsection

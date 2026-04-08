@if (
$comment->user_id == auth()->id() ||
(auth()->id() &&
auth()->user()->can('delete_comments')))
<form method="POST" action="{{ $deleteAction }}">

    @csrf
    @method('DELETE')
    <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
    <button onclick="return confirm('{{ __('Are you sure?') }}')" class="text-red-400 text-xs hover:text-red-500 duration-200 transition-all" type="submit">{{ __('Delete') }}</button>
</form>
@endif

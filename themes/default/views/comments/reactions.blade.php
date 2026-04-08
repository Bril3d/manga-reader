<div class="flex gap-3 items-baseline">
    <form action="{{ route('comments.like.store', $comment->id) }}" method="POST">
        @csrf
        <div class="flex gap-2 items-baseline">
            <button>
                <x-fas-thumbs-up class="h-4 w-4 text-black dark:dark:text-white !text-opacity-60 hover:text-opacity-30 duration-200 transition-all" style="transform: rotateY(180deg)" />
            </button>
            <span class="text-sm text-black dark:text-white">{{ $comment->likesSum() }}</span>
        </div>
    </form>

    <form action="{{ route('comments.dislike.store', $comment->id) }}" method="POST">
        @csrf
        <button>
            <x-fas-thumbs-down class="h-4 w-4 text-black dark:dark:text-white !text-opacity-60 hover:text-opacity-30 duration-200 transition-all" style="transform: rotateY(180deg)" />
        </button>

    </form>
</div>

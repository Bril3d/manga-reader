    <h2 class="block text-lg font-bold mb-3 leading-[1rem]">{{ __('Comments') }} ({{ $comments->count() }})</h2>

    <x-alert.error :errors="$errors" />

    @php
    if ($modelType == 'manga') {
    $storeAction = route('manga.comments.store', $model->slug);
    $deleteAction = route('manga.comments.delete', [$model->slug]);
    } elseif ($modelType == 'chapter') {
    $storeAction = route('chapter.comments.store', [$model->manga->slug, $model->chapter_number]);
    $deleteAction = route('chapter.comments.delete', [$model->manga->slug, $model->chapter_number]);
    }
    @endphp

    <form method="POST" action="{{ $storeAction }}">
        @csrf
        <div class="relative">
            <x-form.input id="comment" name="content" class="py-4" placeholder="{{ __('Add Comment...') }}" required />
            <p class=" text-black dark:text-white !text-opacity-50 text-xs mt-1"><span id="comment-char">0</span>/500 {{ __('Max') }}</p>
            @include('comments.button')
        </div>
    </form>

    <div class="mt-5 flex flex-col gap-4">
        @foreach ($model->comments()->fastPaginate(8) as $comment)
        <div class="flex flex-col gap-4">
            <div class="flex gap-3">
                @php
                $image_url = isset($comment->user->avatar) ? asset('storage/avatars/' . $comment->user->avatar) : asset('images/user/no-image.jpg');
                @endphp
                <img class="h-10 w-10 object-cover object-top rounded-full border-[1px] border-solid border-black/5 dark:border-none" src="{{ $image_url }}" alt="{{ $comment->user->username }}" />
                <div class="flex flex-col gap-2 w-full">
                    <div class="border-[1px] border-solid border-black/5 dark:border-none dark:bg-dark-secondary w-full rounded-md px-5 py-3 pb-4 flex flex-col gap-2">
                        @include('comments.header')
                        @include('comments.body')
                        @include('comments.footer')
                    </div>
                    @include('comments.reactions')
                </div>
            </div>
        </div>
        @endforeach
        <div class="mt-5 flex justify-end">
            {{ $model->comments()->fastPaginate(8)->links('pagination.default') }}
        </div>
    </div>

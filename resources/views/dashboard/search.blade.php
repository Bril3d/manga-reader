@props(['link', 'name' => 'title', 'placeholder', 'button_text'])

<form action="{{ url($link) }}" method="get" class="flex justify-end mt-4 sm:mt-0 w-full sm:w-2/3">
    <input type="hidden" name="todo" value="filter">
    <div class="flex">
        @php
        $input_class = __('direction') === 'rtl' ? '!rounded-r-md rounded-l-none' : '!rounded-r-none rounded-l-md';
        $button_class = __('direction') === 'rtl' ? '!rounded-l-md rounded-r-none' : '!rounded-l-none rounded-r-md';
        @endphp
        <x-form.input :name="$name" :placeholder="$placeholder" :class="$input_class" :required="true" />
        <x-button.primary :class="$button_class">{{ __('Search') }}</x-button.primary>
    </div>
</form>

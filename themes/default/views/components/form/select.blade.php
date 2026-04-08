@props(['label' => null, 'name', 'class' => null, 'selected' => null, 'options' => [], 'multiple' => false])

<div class="flex flex-col gap-2 w-full">
    @if ($label)
    <label for="{{ $name }}" class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/70 font-manrope ml-1">
        {{ $label }}
    </label>
    @endif

    <select name="{{ $name }}" 
            class="w-full px-5 py-3 bg-surface-container-high/50 backdrop-blur-md border border-outline-variant/30 rounded-xl text-on-surface focus:outline-none focus:border-neon-purple focus:ring-4 focus:ring-neon-purple/10 transition-all duration-300 {{ $class }}" 
            {{ $attributes }} 
            @if ($multiple) multiple @endif>
        @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @if (is_array($selected) && in_array($optionValue, $selected)) selected @elseif ($selected==$optionValue) selected @endif class="bg-surface-container-high text-on-surface">
            {{ $optionLabel }}
        </option>
        @endforeach
    </select>
</div>

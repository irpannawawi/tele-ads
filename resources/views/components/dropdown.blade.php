@props(['align' => 'end', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
$alignmentClasses = match ($align) {
    'start' => 'start-0',
    'end' => 'end-0',
    default => '',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div class="dropdown position-relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <button class="dropdown-toggle" @click="open = ! open" aria-expanded="false">
        {{ $trigger }}
    </button>

    <ul x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="dropdown-menu {{ $width }} {{ $alignmentClasses }}"
        style="display: none;"
        @click="open = false">
        {{ $content }}
    </ul>
</div>


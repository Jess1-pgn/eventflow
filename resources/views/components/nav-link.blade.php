@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold text-white bg-white/20 backdrop-blur-sm transition duration-200'
            : 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-indigo-100 hover:text-white hover:bg-white/10 transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

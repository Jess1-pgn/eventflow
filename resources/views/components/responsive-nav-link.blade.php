@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-indigo-500 text-start text-base font-semibold text-indigo-700 bg-indigo-50 rounded-r-lg focus:outline-none transition duration-200'
            : 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-indigo-700 hover:bg-indigo-50/50 hover:border-indigo-300 rounded-r-lg focus:outline-none transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

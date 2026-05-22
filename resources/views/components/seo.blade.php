@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'ogType' => 'website',
    'ogImage' => null,
    'jsonLd' => null,
])

@php
    $appName = config('app.name', 'EventFlow');
    $seoTitle = $title ? "$title — $appName" : $appName;
    $seoDescription = $description ?? 'Discover, organize, and sell tickets to events effortlessly. From concerts to conferences, EventFlow makes it simple.';
    $canonicalUrl = $canonical ?? url()->current();
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ Str::limit(strip_tags($seoDescription), 160) }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($seoDescription), 200) }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ $appName }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($seoDescription), 200) }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif

{{-- JSON-LD Structured Data --}}
@if ($jsonLd)
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endif

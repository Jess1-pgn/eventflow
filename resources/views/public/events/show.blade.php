@php
    $seoEventTitle = $event->meta_title ?: $event->title;
    $seoEventDescription = $event->meta_description ?: Str::limit(strip_tags($event->description_html), 160);
    $seoEventImage = $event->cover_image_path ? asset('storage/' . $event->cover_image_path) : null;
    $seoEventJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event->title,
        'description' => Str::limit(strip_tags($event->description_html), 300),
        'startDate' => $event->starts_at?->toIso8601String(),
        'endDate' => $event->ends_at?->toIso8601String(),
        'eventStatus' => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'url' => route('public.events.show', $event->seo_slug),
        ...($event->venue ? [
            'location' => [
                '@type' => 'Place',
                'name' => $event->venue->name,
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $event->venue->address_line1,
                    'addressLocality' => $event->venue->city,
                    'addressCountry' => $event->venue->country,
                ],
            ],
        ] : []),
        ...($seoEventImage ? ['image' => [$seoEventImage]] : []),
        ...($event->ticketTypes->isNotEmpty() ? [
            'offers' => $event->ticketTypes->map(fn ($tt) => [
                '@type' => 'Offer',
                'name' => $tt->name,
                'price' => $tt->is_free ? '0' : number_format($tt->price_amount / 100, 2, '.', ''),
                'priceCurrency' => $tt->currency ?? 'USD',
                'url' => route('public.checkout.show', $event->seo_slug),
                'availability' => 'https://schema.org/InStock',
            ])->all(),
        ] : []),
        'organizer' => [
            '@type' => 'Person',
            'name' => $event->organizer?->name ?? config('app.name'),
        ],
    ];
@endphp

<x-app-layout
    :seo-title="$seoEventTitle"
    :seo-description="$seoEventDescription"
    :seo-canonical="route('public.events.show', $event->seo_slug)"
    seo-og-type="article"
    :seo-og-image="$seoEventImage"
    :seo-json-ld="$seoEventJsonLd"
>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('public.events.index') }}" class="w-8 h-8 rounded-full bg-white/80 flex items-center justify-center hover:bg-white transition shadow-sm">
                <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Main Event Card -->
            <article class="card overflow-hidden">
                <div class="h-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500"></div>
                <div class="p-6 md:p-8 space-y-6">
                    <!-- Date & Time -->
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $event->starts_at?->setTimezone($event->timezone)->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $event->starts_at?->setTimezone($event->timezone)->format('H:i') }} — {{ $event->ends_at?->setTimezone($event->timezone)->format('H:i') }}
                                    <span class="text-gray-400">({{ $event->timezone }})</span>
                                </p>
                            </div>
                        </div>

                        @if ($event->venue)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $event->venue->name }}</p>
                                    <p class="text-xs text-gray-500">{{ implode(', ', array_filter([$event->venue->address_line1, $event->venue->city, $event->venue->country])) }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Categories & Tags -->
                    <div class="flex flex-wrap gap-2">
                        @foreach ($event->categories as $category)
                            <span class="badge-primary">{{ $category->name }}</span>
                        @endforeach
                        @foreach ($event->tags as $tag)
                            <span class="inline-flex items-center rounded-full bg-violet-50 px-3 py-1 text-xs font-medium text-violet-700">#{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <!-- Description -->
                    @if ($event->description_html)
                        <div class="prose prose-indigo max-w-none prose-headings:font-bold prose-a:text-indigo-600">{!! $event->description_html !!}</div>
                    @endif

                    <!-- Share Section -->
                    <div class="pt-5 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Share this event</p>
                        <div class="flex flex-wrap gap-2">
                            <a class="inline-flex items-center gap-2 rounded-xl bg-green-50 px-4 py-2.5 text-sm font-medium text-green-700 hover:bg-green-100 transition" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode(route('public.events.show', $event->seo_slug)) }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                WhatsApp
                            </a>
                            <a class="inline-flex items-center gap-2 rounded-xl bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700 hover:bg-blue-100 transition" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('public.events.show', $event->seo_slug)) }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                            <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-gray-50 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 transition" onclick="navigator.clipboard.writeText('{{ route('public.events.show', $event->seo_slug) }}')">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" /></svg>
                                Copy link
                            </button>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="pt-5 border-t border-gray-100">
                        <a href="{{ route('public.checkout.show', $event->seo_slug) }}" class="btn-primary text-sm">
                            <svg class="w-5 h-5 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                            Buy Tickets
                        </a>
                    </div>
                </div>
            </article>

            <!-- Ticket Types -->
            <div class="card p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Available tickets</h3>
                <div class="space-y-3">
                    @forelse ($event->ticketTypes as $ticketType)
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <span class="text-sm font-semibold text-gray-900">{{ $ticketType->name }}</span>
                            <span class="text-sm font-bold {{ $ticketType->is_free ? 'text-green-600' : 'text-indigo-600' }}">
                                {{ $ticketType->is_free ? 'Free' : number_format($ticketType->price_amount / 100, 2).' '.$ticketType->currency }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No ticket types configured yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

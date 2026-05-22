<x-app-layout
    :seo-title="__('ui.events')"
    seo-description="Discover upcoming events near you. Browse concerts, conferences, workshops and more on EventFlow."
    :seo-canonical="route('public.events.index')"
>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('ui.events') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Discover upcoming events near you</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if (session('dashboard_gate_message'))
                <div class="rounded-2xl bg-gradient-to-r from-indigo-50 to-violet-50 border border-indigo-100 px-5 py-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                        </div>
                        <span class="text-sm font-medium text-indigo-800">{{ session('dashboard_gate_message') }}</span>
                    </div>
                    <a href="{{ route('dashboard', ['from_events' => 1]) }}" class="btn-primary text-xs whitespace-nowrap">
                        My dashboard
                    </a>
                </div>
            @endif

            <!-- Search & Filters -->
            <form method="GET" action="{{ route('public.events.index') }}" class="card p-5">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        <input name="q" value="{{ request('q') }}" placeholder="Search events..." class="form-input-modern w-full pl-10" />
                    </div>
                    <select name="category" class="form-input-modern">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input name="city" value="{{ request('city') }}" placeholder="City" class="form-input-modern" />
                    <input name="date_from" type="date" value="{{ request('date_from') }}" class="form-input-modern" />
                    <input name="date_to" type="date" value="{{ request('date_to') }}" class="form-input-modern" />
                </div>
                <div class="mt-4 flex items-center gap-3">
                    <button class="btn-primary text-xs">
                        <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                        Filter
                    </button>
                    <a href="{{ route('public.events.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">Reset</a>
                </div>
            </form>

            <!-- Event Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse ($events as $event)
                    @php
                        $eventImage = $event->cover_image_path
                            ? (str_starts_with($event->cover_image_path, 'http')
                                ? $event->cover_image_path
                                : asset('storage/'.$event->cover_image_path))
                            : 'https://picsum.photos/seed/'.rawurlencode($event->seo_slug).'/960/540';
                    @endphp
                    <article class="card overflow-hidden group">
                        <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                            <img
                                src="{{ $eventImage }}"
                                alt="{{ $event->title }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/35 via-black/10 to-transparent"></div>
                        </div>
                        <!-- Gradient top bar -->
                        <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $event->title }}</h3>
                                @auth
                                    @if (auth()->user()->hasRole('attendee'))
                                        @if (in_array($event->id, $likedEventIds, true))
                                            <form method="POST" action="{{ route('public.events.unfavorite', $event->seo_slug) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="shrink-0 w-9 h-9 rounded-full bg-rose-50 flex items-center justify-center hover:bg-rose-100 transition" title="Remove from favorites">
                                                    <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" /></svg>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('public.events.favorite', $event->seo_slug) }}">
                                                @csrf
                                                <button type="submit" class="shrink-0 w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center hover:bg-rose-50 transition group/heart" title="Add to favorites">
                                                    <svg class="w-5 h-5 text-gray-300 group-hover/heart:text-rose-400 transition" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            </div>

                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                {{ $event->starts_at?->setTimezone($event->timezone)->format('M d, Y · H:i') }}
                            </div>

                            @if ($event->venue)
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-violet-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                    {{ $event->venue->name }}{{ $event->venue->city ? ', '.$event->venue->city : '' }}
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($event->categories as $category)
                                    <span class="badge-primary">{{ $category->name }}</span>
                                @endforeach
                            </div>

                            <a href="{{ route('public.events.show', $event->seo_slug) }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition group/link">
                                View details
                                <svg class="w-4 h-4 ms-1 group-hover/link:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 text-center py-16">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                        <p class="text-gray-500 font-medium">No events found</p>
                        <p class="text-sm text-gray-400 mt-1">Try adjusting your filters</p>
                    </div>
                @endforelse
            </div>

            <div>{{ $events->links() }}</div>
        </div>
    </div>
</x-app-layout>

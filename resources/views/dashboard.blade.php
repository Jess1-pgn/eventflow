<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Card -->
            <div class="card overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Here's what's happening with your account.</p>
                    </div>
                    @if (auth()->user()->hasRole('attendee'))
                        <a href="{{ route('public.events.index') }}" class="btn-primary text-sm whitespace-nowrap">
                            <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                            Browse events
                        </a>
                    @endif
                </div>
            </div>

            @if (auth()->user()->hasRole('attendee'))
                <!-- Liked Events -->
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Liked events</h3>
                    </div>
                    @if ($likedEvents->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                            <p class="text-sm text-gray-500">No liked events yet</p>
                            <p class="text-xs text-gray-400 mt-1">Events you like will appear here</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach ($likedEvents as $event)
                                <a href="{{ route('public.events.show', $event->seo_slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                                    <div class="w-2 h-2 rounded-full bg-indigo-400 shrink-0"></div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $event->title }}</span>
                                    <svg class="w-4 h-4 text-gray-300 ms-auto group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Paid Events -->
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Paid events</h3>
                    </div>
                    @if ($paidEvents->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                            <p class="text-sm text-gray-500">No tickets purchased yet</p>
                            <p class="text-xs text-gray-400 mt-1">Your purchased tickets will appear here</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach ($paidEvents as $event)
                                <a href="{{ route('public.events.show', $event->seo_slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                                    <div class="w-2 h-2 rounded-full bg-green-400 shrink-0"></div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $event->title }}</span>
                                    <svg class="w-4 h-4 text-gray-300 ms-auto group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

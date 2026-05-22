<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">{{ $isSuperAdmin ? 'Platform Analytics' : 'Organizer Analytics' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="stat-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-[3rem] -mr-2 -mt-2"></div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Events</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $eventsCount }}</p>
                    </div>
                </div>

                <div class="stat-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-violet-50 rounded-bl-[3rem] -mr-2 -mt-2"></div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tickets Sold</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ticketsSold }}</p>
                    </div>
                </div>

                <div class="stat-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-bl-[3rem] -mr-2 -mt-2"></div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Ticket Capacity</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ticketCapacity }}</p>
                    </div>
                </div>

                <div class="stat-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-bl-[3rem] -mr-2 -mt-2"></div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Revenue</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($revenueAmount / 100, 2) }} <span class="text-base font-medium text-gray-400">MAD</span></p>
                    </div>
                </div>
            </div>

            <!-- Recent Events Table -->
            <div class="card overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Events</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Capacity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ $event->title }}</td>
                                        <td class="px-4 py-4">
                                            @php
                                                $badgeClass = match($event->status) {
                                                    'published' => 'badge-success',
                                                    'draft' => 'badge-warning',
                                                    'archived' => 'badge',
                                                    default => 'badge',
                                                };
                                            @endphp
                                            <span class="{{ $badgeClass }}">{{ ucfirst($event->status) }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">{{ (int) ($event->ticket_capacity_sum ?? 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

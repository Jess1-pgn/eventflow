<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('ui.events') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Manage your events</p>
            </div>
            @can('create', App\Models\Event::class)
                <a href="{{ route('dashboard.events.create') }}" class="btn-primary text-sm">
                    <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    {{ __('ui.create_event') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card overflow-hidden">
                <div class="p-6">
                    @if (session('status'))
                        <div class="mb-4 rounded-xl bg-green-50 border border-green-100 px-4 py-3 flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if ($events->isEmpty())
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                            <p class="text-gray-500 font-medium">{{ __('No events found yet.') }}</p>
                            <p class="text-sm text-gray-400 mt-1">Create your first event to get started</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Title') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Starts At') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Timezone') }}</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($events as $event)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-4 py-4">
                                                <span class="text-sm font-semibold text-gray-900">{{ $event->title }}</span>
                                            </td>
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
                                            <td class="px-4 py-4 text-sm text-gray-500">{{ $event->starts_at?->setTimezone($event->timezone)->format('M d, Y · H:i') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-400">{{ $event->timezone }}</td>
                                            <td class="px-4 py-4 text-right">
                                                <div class="flex items-center justify-end gap-1">
                                                    @can('update', $event)
                                                        <a href="{{ route('dashboard.events.edit', $event) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                                            {{ __('Edit') }}
                                                        </a>
                                                        <form method="POST" action="{{ route('dashboard.events.duplicate', $event) }}">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-100 transition">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                                                                {{ __('Duplicate') }}
                                                            </button>
                                                        </form>
                                                        @if ($event->status !== \App\Models\Event::STATUS_ARCHIVED)
                                                            <form method="POST" action="{{ route('dashboard.events.archive', $event) }}">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-amber-600 hover:bg-amber-50 transition">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
                                                                    {{ __('Archive') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                    @can('delete', $event)
                                                        <form method="POST" action="{{ route('dashboard.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50 transition">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">{{ $events->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

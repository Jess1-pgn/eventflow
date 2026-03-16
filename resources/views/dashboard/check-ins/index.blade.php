<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Staff Check-In</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Scan Ticket -->
            <div class="card overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                <div class="p-6 md:p-8 space-y-4">
                    @if (session('status'))
                        <div class="rounded-xl bg-green-50 border border-green-100 px-4 py-3 flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" /></svg>
                        Scan ticket
                    </h3>

                    <form method="POST" action="{{ route('dashboard.check-ins.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="ticket_code" :value="__('Ticket Code')" />
                            <x-text-input id="ticket_code" name="ticket_code" type="text" class="mt-1 block w-full" :value="old('ticket_code')" required placeholder="Enter or scan ticket code" />
                            <x-input-error :messages="$errors->get('ticket_code')" class="mt-2" />
                        </div>

                        <x-primary-button>
                            <svg class="w-4 h-4 me-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            {{ __('Validate Check-In') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Manual Override -->
            <div class="card p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                    Manual Override
                </h3>
                <form method="POST" action="{{ route('dashboard.check-ins.override', 1) }}" class="space-y-4" onsubmit="this.action = this.action.replace('/1', '/' + this.ticket_id.value)">
                    @csrf
                    <div>
                        <x-input-label for="ticket_id_override" :value="__('Ticket ID')" />
                        <x-text-input name="ticket_id" id="ticket_id_override" type="number" min="1" class="mt-1 block w-full" placeholder="Enter ticket ID" required />
                    </div>
                    <div>
                        <x-input-label for="override_reason" :value="__('Reason')" />
                        <x-text-input name="override_reason" id="override_reason" type="text" class="mt-1 block w-full" placeholder="Override reason" required />
                    </div>
                    <button class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:from-amber-600 hover:to-orange-600 transition-all focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                        Save Override
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

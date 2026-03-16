<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Order Confirmed</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Success Banner -->
            <div class="card overflow-hidden">
                <div class="h-2 bg-gradient-to-r from-green-400 to-emerald-500"></div>
                <div class="p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">Order #{{ $order->id }} confirmed!</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $order->event->title }}</p>
                    </div>
                </div>
                <div class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="grid grid-cols-3 gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Subtotal</p>
                            <p class="text-sm font-bold text-gray-900">{{ number_format($order->subtotal_amount / 100, 2) }} {{ $order->currency }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Discount</p>
                            <p class="text-sm font-bold text-green-600">-{{ number_format($order->discount_amount / 100, 2) }} {{ $order->currency }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total</p>
                            <p class="text-sm font-bold text-indigo-600">{{ number_format($order->total_amount / 100, 2) }} {{ $order->currency }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets -->
            <div class="card p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                    Your tickets
                </h3>

                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        @foreach ($item->tickets as $ticket)
                            <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $item->ticketType->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $ticket->holder_first_name }} {{ $ticket->holder_last_name }}</p>
                                </div>
                                <div class="text-right">
                                    <code class="px-3 py-1.5 rounded-lg bg-indigo-50 text-xs font-mono font-bold text-indigo-700">{{ $ticket->ticket_code }}</code>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

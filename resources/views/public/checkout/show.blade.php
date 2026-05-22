<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('public.events.show', $event->seo_slug) }}" class="w-8 h-8 rounded-full bg-white/80 flex items-center justify-center hover:bg-white transition shadow-sm">
                <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Checkout</h2>
                <p class="mt-0.5 text-sm text-gray-500">{{ $event->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('public.checkout.store', $event->seo_slug) }}" class="space-y-6">
                @csrf

                <!-- Buyer Info -->
                <div class="card p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                        Your details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="buyer_first_name" :value="__('First Name')" />
                            <x-text-input id="buyer_first_name" name="buyer_first_name" type="text" class="mt-1 block w-full" :value="old('buyer_first_name')" required />
                            <x-input-error :messages="$errors->get('buyer_first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="buyer_last_name" :value="__('Last Name')" />
                            <x-text-input id="buyer_last_name" name="buyer_last_name" type="text" class="mt-1 block w-full" :value="old('buyer_last_name')" />
                            <x-input-error :messages="$errors->get('buyer_last_name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="buyer_email" :value="__('Email')" />
                            <x-text-input id="buyer_email" name="buyer_email" type="email" class="mt-1 block w-full" :value="old('buyer_email')" required />
                            <x-input-error :messages="$errors->get('buyer_email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="buyer_phone" :value="__('Phone')" />
                            <x-text-input id="buyer_phone" name="buyer_phone" type="text" class="mt-1 block w-full" :value="old('buyer_phone')" />
                            <x-input-error :messages="$errors->get('buyer_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="promo_code" :value="__('Promo Code')" />
                        <div class="relative mt-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
                            <x-text-input id="promo_code" name="promo_code" type="text" class="block w-full pl-10" :value="old('promo_code')" placeholder="Enter promo code (optional)" />
                        </div>
                        <x-input-error :messages="$errors->get('promo_code')" class="mt-2" />
                    </div>
                </div>

                <!-- Tickets -->
                <div class="card p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                        Select tickets
                    </h3>
                    <div class="space-y-3">
                        @foreach ($event->ticketTypes as $ticketType)
                            <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $ticketType->name }}</p>
                                    <p class="text-sm font-medium {{ $ticketType->is_free ? 'text-green-600' : 'text-indigo-600' }}">
                                        {{ $ticketType->is_free ? 'Free' : number_format($ticketType->price_amount / 100, 2).' '.$ticketType->currency }}
                                    </p>
                                </div>

                                <div class="w-24">
                                    <x-text-input
                                        name="quantities[{{ $ticketType->id }}]"
                                        type="number"
                                        min="0"
                                        max="{{ $ticketType->max_per_order ?? 99 }}"
                                        class="block w-full text-center"
                                        :value="old('quantities.'.$ticketType->id, 0)"
                                    />
                                </div>
                            </div>
                        @endforeach

                        <x-input-error :messages="$errors->get('quantities')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="!px-8">
                        <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" /></svg>
                        {{ __('Place Order') }}
                    </x-primary-button>
                    <a href="{{ route('public.events.show', $event->seo_slug) }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">Back to event</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

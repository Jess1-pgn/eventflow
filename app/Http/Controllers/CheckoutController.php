<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Event;
use App\Models\Order;
use App\Models\PromoCode;
use App\Models\Ticket;
use App\Support\TicketQrSigner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Event $event): View
    {
        $this->ensureCheckoutAccess($event);

        $event->load(['ticketTypes' => fn ($query) => $query->orderBy('id')]);

        return view('public.checkout.show', [
            'event' => $event,
        ]);
    }

    public function store(CheckoutRequest $request, Event $event): RedirectResponse
    {
        $this->ensureCheckoutAccess($event);

        $validated = $request->validated();
        $quantities = collect($validated['quantities'] ?? [])
            ->mapWithKeys(fn ($qty, $ticketTypeId) => [(int) $ticketTypeId => (int) $qty])
            ->filter(fn (int $qty) => $qty > 0);

        if ($quantities->isEmpty()) {
            return back()->withErrors(['quantities' => 'Select at least one ticket.'])->withInput();
        }

        $ticketTypes = $event->ticketTypes()->whereIn('id', $quantities->keys())->get()->keyBy('id');

        $subtotal = 0;

        foreach ($quantities as $ticketTypeId => $qty) {
            $ticketType = $ticketTypes->get($ticketTypeId);

            if ($ticketType === null) {
                return back()->withErrors(['quantities' => 'Invalid ticket type selected.'])->withInput();
            }

            if ($ticketType->max_per_order !== null && $qty > $ticketType->max_per_order) {
                return back()->withErrors([
                    'quantities' => "{$ticketType->name} allows max {$ticketType->max_per_order} per order.",
                ])->withInput();
            }

            $unitAmount = $ticketType->is_free ? 0 : (int) $ticketType->price_amount;
            $subtotal += ($unitAmount * $qty);
        }

        $discountAmount = 0;
        $promo = $this->resolvePromoCode($request, $event);

        if ($promo !== null) {
            $discountAmount = $promo->discount_type === PromoCode::TYPE_PERCENT
                ? (int) floor(($subtotal * $promo->discount_value) / 100)
                : (int) $promo->discount_value;

            $discountAmount = min($discountAmount, $subtotal);
        }

        $currency = (string) ($ticketTypes->first()?->currency ?? 'MAD');

        $order = Order::create([
            'event_id' => $event->id,
            'buyer_user_id' => Auth::id(),
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'] ?? null,
            'status' => Order::STATUS_PAID,
            'subtotal_amount' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => max(0, $subtotal - $discountAmount),
            'currency' => $currency,
            'payment_provider' => 'fake',
            'payment_reference' => 'SIM-'.Str::upper(Str::random(10)),
        ]);

        foreach ($quantities as $ticketTypeId => $qty) {
            $ticketType = $ticketTypes->get($ticketTypeId);
            $unitAmount = $ticketType->is_free ? 0 : (int) $ticketType->price_amount;

            $orderItem = $order->items()->create([
                'ticket_type_id' => $ticketType->id,
                'unit_price_amount' => $unitAmount,
                'qty' => $qty,
            ]);

            for ($i = 0; $i < $qty; $i++) {
                $ticketCode = $this->generateUniqueTicketCode();

                $payload = json_encode([
                    'ticket_code' => $ticketCode,
                    'event_id' => $event->id,
                    'order_id' => $order->id,
                    'issued_at' => now()->toIso8601String(),
                ], JSON_THROW_ON_ERROR);

                $signature = TicketQrSigner::signPayload($payload);

                $orderItem->tickets()->create([
                    'ticket_code' => $ticketCode,
                    'holder_first_name' => $validated['buyer_first_name'],
                    'holder_last_name' => $validated['buyer_last_name'] ?? null,
                    'holder_email' => $validated['buyer_email'],
                    'holder_phone' => $validated['buyer_phone'] ?? null,
                    'qr_payload_json' => $payload,
                    'qr_signature' => $signature,
                ]);
            }
        }

        if ($promo !== null) {
            $promo->increment('used_count');
        }

        session(['last_checkout_order_id' => $order->id]);

        return redirect()->route('public.checkout.success', $order);
    }

    public function success(Order $order): View
    {
        $allowedBySession = (int) session('last_checkout_order_id') === $order->id;
        $allowedByUser = Auth::check() && (
            Auth::user()->hasRole('super-admin') ||
            $order->buyer_user_id === Auth::id()
        );

        abort_unless($allowedBySession || $allowedByUser, 403);

        $order->load(['event', 'items.ticketType', 'items.tickets']);

        return view('public.checkout.success', [
            'order' => $order,
        ]);
    }

    private function resolvePromoCode(Request $request, Event $event): ?PromoCode
    {
        $code = trim((string) $request->input('promo_code', ''));

        if ($code === '') {
            return null;
        }

        $promo = PromoCode::query()
            ->whereRaw('LOWER(code) = ?', [Str::lower($code)])
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('event_id')->orWhere('event_id', $event->id))
            ->first();

        if ($promo === null) {
            return null;
        }

        if ($promo->starts_at !== null && now()->lt($promo->starts_at)) {
            return null;
        }

        if ($promo->ends_at !== null && now()->gt($promo->ends_at)) {
            return null;
        }

        if ($promo->max_uses !== null && $promo->used_count >= $promo->max_uses) {
            return null;
        }

        return $promo;
    }

    private function generateUniqueTicketCode(): string
    {
        do {
            $code = Str::upper(Str::random(12));
        } while (Ticket::query()->where('ticket_code', $code)->exists());

        return $code;
    }

    private function ensureCheckoutAccess(Event $event): void
    {
        if ($event->status === Event::STATUS_PUBLISHED) {
            return;
        }

        $canAccessUnpublished = Auth::check() && (
            Auth::user()->hasRole('super-admin') ||
            $event->organizer_id === Auth::id()
        );

        abort_unless($canAccessUnpublished, 404);
    }
}

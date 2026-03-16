<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Support\TicketQrSigner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $attendees = User::query()->whereHas('roles', fn ($q) => $q->where('name', 'attendee'))->get();

        if ($attendees->isEmpty()) {
            return;
        }

        // Order 1: Tech Conference - 2 Early Bird tickets
        $event1 = Event::query()->where('seo_slug', 'tech-conference-2026')->first();
        if ($event1) {
            $ticketType = $event1->ticketTypes()->where('name', 'Early Bird')->first();
            if ($ticketType) {
                $order1 = Order::create([
                    'event_id' => $event1->id,
                    'buyer_user_id' => $attendees->first()->id,
                    'buyer_email' => $attendees->first()->email,
                    'buyer_phone' => '+1-555-0101',
                    'status' => Order::STATUS_PAID,
                    'subtotal_amount' => 59800, // 2 × $299
                    'discount_amount' => 0,
                    'total_amount' => 59800,
                    'currency' => 'USD',
                    'payment_provider' => 'fake',
                    'payment_reference' => 'DEMO-'.Str::upper(Str::random(10)),
                ]);

                // Create 2 order items with tickets
                for ($i = 0; $i < 2; $i++) {
                    $orderItem = $order1->items()->create([
                        'ticket_type_id' => $ticketType->id,
                        'unit_price_amount' => $ticketType->price_amount,
                        'qty' => 1,
                    ]);

                    $ticketCode = strtoupper(Str::random(12));
                    $payload = json_encode([
                        'ticket_code' => $ticketCode,
                        'event_id' => $event1->id,
                        'order_id' => $order1->id,
                        'issued_at' => now()->toIso8601String(),
                    ], JSON_THROW_ON_ERROR);
                    $signature = TicketQrSigner::signPayload($payload);

                    $orderItem->tickets()->create([
                        'ticket_code' => $ticketCode,
                        'holder_first_name' => $i === 0 ? $attendees->first()->name : 'Guest',
                        'holder_last_name' => $i === 0 ? '' : ($i + 1),
                        'holder_email' => $attendees->first()->email,
                        'holder_phone' => '+1-555-0101',
                        'qr_payload_json' => $payload,
                        'qr_signature' => $signature,
                    ]);
                }
            }
        }

        // Order 2: Design Workshop - 1 Participant ticket
        $event2 = Event::query()->where('seo_slug', 'design-workshop-ux')->first();
        if ($event2 && $attendees->count() > 1) {
            $ticketType = $event2->ticketTypes()->where('name', 'Participant')->first();
            if ($ticketType) {
                $attendee = $attendees->get(1);
                $order2 = Order::create([
                    'event_id' => $event2->id,
                    'buyer_user_id' => $attendee->id,
                    'buyer_email' => $attendee->email,
                    'buyer_phone' => '+1-555-0102',
                    'status' => Order::STATUS_PAID,
                    'subtotal_amount' => $ticketType->price_amount,
                    'discount_amount' => 0,
                    'total_amount' => $ticketType->price_amount,
                    'currency' => 'USD',
                    'payment_provider' => 'fake',
                    'payment_reference' => 'DEMO-'.Str::upper(Str::random(10)),
                ]);

                $orderItem = $order2->items()->create([
                    'ticket_type_id' => $ticketType->id,
                    'unit_price_amount' => $ticketType->price_amount,
                    'qty' => 1,
                ]);

                $ticketCode = strtoupper(Str::random(12));
                $payload = json_encode([
                    'ticket_code' => $ticketCode,
                    'event_id' => $event2->id,
                    'order_id' => $order2->id,
                    'issued_at' => now()->toIso8601String(),
                ], JSON_THROW_ON_ERROR);
                $signature = TicketQrSigner::signPayload($payload);

                $orderItem->tickets()->create([
                    'ticket_code' => $ticketCode,
                    'holder_first_name' => $attendee->name,
                    'holder_last_name' => '',
                    'holder_email' => $attendee->email,
                    'holder_phone' => '+1-555-0102',
                    'qr_payload_json' => $payload,
                    'qr_signature' => $signature,
                ]);
            }
        }

        // Order 3: Wellness Summit - 1 Full Summit Pass
        $event4 = Event::query()->where('seo_slug', 'wellness-fitness-summit')->first();
        if ($event4 && $attendees->count() > 1) {
            $ticketType = $event4->ticketTypes()->where('name', 'Full Summit Pass')->first();
            if ($ticketType) {
                $attendee = $attendees->get(1);
                $order3 = Order::create([
                    'event_id' => $event4->id,
                    'buyer_user_id' => $attendee->id,
                    'buyer_email' => $attendee->email,
                    'buyer_phone' => '+1-555-0103',
                    'status' => Order::STATUS_PAID,
                    'subtotal_amount' => $ticketType->price_amount,
                    'discount_amount' => 0,
                    'total_amount' => $ticketType->price_amount,
                    'currency' => 'USD',
                    'payment_provider' => 'fake',
                    'payment_reference' => 'DEMO-'.Str::upper(Str::random(10)),
                ]);

                $orderItem = $order3->items()->create([
                    'ticket_type_id' => $ticketType->id,
                    'unit_price_amount' => $ticketType->price_amount,
                    'qty' => 1,
                ]);

                $ticketCode = strtoupper(Str::random(12));
                $payload = json_encode([
                    'ticket_code' => $ticketCode,
                    'event_id' => $event4->id,
                    'order_id' => $order3->id,
                    'issued_at' => now()->toIso8601String(),
                ], JSON_THROW_ON_ERROR);
                $signature = TicketQrSigner::signPayload($payload);

                $orderItem->tickets()->create([
                    'ticket_code' => $ticketCode,
                    'holder_first_name' => $attendee->name,
                    'holder_last_name' => '',
                    'holder_email' => $attendee->email,
                    'holder_phone' => '+1-555-0103',
                    'qr_payload_json' => $payload,
                    'qr_signature' => $signature,
                ]);
            }
        }
    }
}
